<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 17/12/2015
 * Time: 2:03 PM
 */
class DataIntegrityHelper
{
    public static $QUERIES = [
        "select * from [user] where not exists (select * from company where [user].company = company.id and [user].tenant in (company.id,company.tenant))",
        "select * from visitor where not exists (select * from company where visitor.company = company.id and visitor.tenant in (company.id,company.tenant))",
        "select * from visit where card_type < 5 and not exists (select * from [user] where visit.host = [user].id and visit.tenant = [user].tenant)",
        "select * from visit where card_type >= 5 and not exists (select * from visitor where visit.host = visitor.id and visit.tenant = visitor.tenant)",
        "select * from visitor JOIN company ON visitor.company = company.id WHERE visitor.tenant <> company.tenant",
        "select * from visit JOIN visit_reason ON visit.reason = visit_reason.id WHERE visit.tenant <> visit_reason.tenant"
    ];

    public static $DATA_FIXES = [
        [
            // fix issue where vsisitors have been allocated to a tenant
            'trigger'=>'SELECT * FROM visit JOIN visit_reason ON visit.reason = visit_reason.id WHERE visit.tenant <> visit_reason.tenant',
            'fix'=>['UPDATE visitor JOIN company ON visitor.company = company.id SET visitor.tenant = company.tenant WHERE visitor.tenant <> company.tenant'],
        ],
        [
            //fix issue where visit reason is taken from wrong tenant
            'trigger'=>'SELECT * FROM visit JOIN visit_reason ON visit.reason = visit_reason.id WHERE visit.tenant <> visit_reason.tenant',
            'fix'=>["INSERT INTO visit_reason (is_deleted,module,reason,tenant,tenant_agent)
                     SELECT r.is_deleted, r.module, r.reason,v.tenant,null
                     FROM visit v JOIN visit_reason r ON v.reason = r.id
                     WHERE v.tenant <> r.tenant
                     AND NOT EXISTS (SELECT *
                            FROM visit_reason a
                            WHERE a.tenant = v.tenant
                            and a.reason = r.reason)",
                    "UPDATE visit v
                        JOIN visit_reason o on v.reason = o.id AND v.tenant <> o.tenant
                        JOIN visit_reason n ON n.reason = o.reason AND n.tenant = v.tenant
                    SET v.reason = n.id"
                    ]
        ],
    ];

    public static function checkDatabase(){
        foreach(DataIntegrityHelper::$QUERIES as $sql) {
            $dbSql = $sql;
            if('mysql' == Yii::app()->db->driverName){
                $dbSql = str_replace("[","`",str_replace("]","`",$dbSql));
            }

            $rows = Yii::app()->db->createCommand($dbSql)->query();
            if(sizeof($rows)>0){
                throw new CException("Integrity check failed. Query was ".$dbSql);
            }
        }
    }

}