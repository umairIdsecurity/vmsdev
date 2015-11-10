<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 29/10/2015
 * Time: 9:56 PM
 */
class Avms7ExportCommand extends CConsoleCommand
{
    public function actionImport($fileName){

        #open the csv
        $rows = file($fileName);
        $headers=null;

        # for each row
        foreach($rows as $row)
        {
            $raw =str_getcsv($row,",",'"','\\');
            $data = $this->cleanse($raw);
            if(!$headers) {

                $headers = $data;
                echo implode(',',$headers);

            } else {

                $rowValues = [];

                $values = $data;

                for($i=0;$i<sizeof($values);$i++)
                {
                    $rowValues[$headers[$i]] = $values[$i];
                }

                $this->applyRow($rowValues);
            }
        }
    }


    public function applyRow($row)
    {

    }

    public function actionExtractTenant($airportCode)
    {
        $tenant = "select id from company where code = '$airportCode' and company_type = 1";


        $tenant_agent = 1;
        $workstation = 1;
        $queries = [
            'tenant' => "
                select id as id,
                       1 as created_by,
                       0 as is_deleted
                from users
                where level = 3
                and ibcode = '$airportCode'
                limit 3
            ",
            'tenant_agent' => "
                select t.id as id,
                       a.id as tenant_id,
                       'AVMS' as for_module,
                       1 as created_by,
                       0 as is_deleted
                from users t
                      join users a on a.OwnerId = t.id
                              and t.level = 3
                              and a.level = 6
                              and t.ibcode = '$airportCode'
                              and a.ibcode = '$airportCode'
            ",
            "company" => "
                select c.id,
                  c.company as company,
                  c.company as trading_name,
                  CONCAT_WS(' ',c.FirstName, c.LastName)  as contact,
                  CONCAT_WS(' ',c.Unit,c.StreetNo,c.Street,c.StreetType,c.Suburb,c.State,c.PostCode) as billing_address,
                  c.EmailAddress as email_address,
                  c.Telephone as office_number,
                  c.Mobile as mobile_number,
                  1 as created_by_user,
                  1 as created_by_visitor,
                  t.id as tenant,
                  a.id as tenant_agent,
                  0 as is_deleted,
                  null as cardCount,
                  3 as company_type
                from users t
                    left join users a on a.ownerid = t.id and a.level = 6 and a.ibcode = 'MBW'
                    join users c on c.ownerid in (t.id,a.id) and c.level = 4
                where t.ibcode = 'MBW'
                and t.level = 3
            ",
            'visitors' =>
                "select v.ID as id,
                v.FirstName as first_name,
                v.MiddleName as middle_name,
                v.LastName as last_name,
                v.EmailAddress as email,
                IFNULL(v.Mobile,v.Telephone) as contact_number,
                v.DateOfBirth as date_of_birth,
                v.Company as company,
                v.Password as password,
                v.Password as photo,
                v.Unit as contact_unit,
                v.StreetNo as contact_street_no,
                v.Street as contact_street_name,
                v.StreetType as contact_street_type,
                v.Suburb as contact_suburb,
                v.State as contact_state,
                v.PostCode as contact_post_code,
                v.Country as contact_country,
                ad.asic_number as asic_no,
                ad.asic_expiry as asic_expiry,

                idA.DocumentType as identification_type,
                idA.CountryIssue as identification_country_issued,
                idA.Number as identification_document_no,
                idA.Expiry as identification_document_expiry,
                idB.DocumentType as identification_name1,
                idB.CountryIssue as identification_country_issued1,
                idB.Number as identification_document_no1,
                idB.Expiry as identification_document_expiry1,
                idC.DocumentType as identification_name2,
                idC.CountryIssue as identification_country_issued2,
                idC.Number as identification_document_no2,
                idC.Expiry as identification_document_expiry2,
                t.id as tenant,
                ta.id as tenant_agent

                from users t
                  left join users ta on ta.ownerid = t.id and ta.level = 6
                  join users v on v.ownerid in (t.ID,ta.ID) and v.level in (5,10)
                  left join asic_data ad on ad.UserID = v.id
                  left join identifications idA
                               on v.id = idA.UserId
                               and idA.documenttype > ''
                               and idA.id = (select idAA.id
                                               from identifications idAA
                                               where idAA.UserID = v.id
                                               order by id desc
                                               limit 1)
                  left join identifications idB
                               on v.id = idB.UserId
                               and idB.documenttype > ''
                               and idB.id = (select idBB.id
                                               from identifications idBB
                                               where idBB.UserID = v.id
                                               order by id desc
                                               limit 1,1)
                   left join identifications idC
                               on v.id = idC.UserId
                               and idC.documenttype > ''
                               and idC.id = (select idCC.id
                                               from identifications idCC
                                               where idCC.UserID = v.id
                                               order by id desc
                                               limit 2,1)
                where t.IBCode = '$airportCode'
                ",

            'visits' =>
                "select v.id as id,
                       v.visitorid as visitor,
                       9 as card_type,
                       t.ID as card,
                       t.visitor_type as visitor_type,
                       v.ReasonNo as reason,
                       1 as visitor_status,
                       c.UserID as host,
                       c.UserID as created_by,
                       v.Date as date_in,
                       v.Time as time_in,
                       c.Date as date_out,
                       c.Time as time_out,
                       v.Date as date_check_in,
                       v.Time as time_check_in,
                       c.Date as date_check_out,
                       c.Time as time_check_out,
                       case
                        when v.IsClosed = 0 then 1
                        else 0
                       end as visit_status,
                       $workstation as workstaton,
                       $tenant as tenant,
                       $tenant_agent as tenant_agent,
                       0 as is_deleted,
                       c.Date as finish_date,
                       c.Time as finish_time,
                       c.DateCardReturned as card_returned_date,
                       n.Reason as negate_reason,
                       c.Date as visit_closed_date,
                       v.UserID as closed_by,
                       1 as asic_declaration,
                       1 as asic_verification,
                       null as company,
                       1 as is_listed
                from log_visit v
                        join oc_set oc on v.SetID = oc.Id and oc.AirportCode = '$airportCode'
                        join card_type t on t.ID = oc.CID
                        left join close_visit c on v.ID = c.LoggedId
                        left join log_negate n on c.Id = n.closedid
                        left join visitor_company vc on v.id = vc.visitorId

              ",

        ];

        foreach($queries as $name=>$sql){
            echo "\r\n".$sql;
        }

    }


    public function GetRow($sql){
        
    }

    public function getQueries($airportCode)
    {
        return [
            'tenant' => "
                select *
                from users
                where level = 3
                and ibcode = '$airportCode'
                order by id asc
                limit 1
            ",
            'tenant_agent' => "
                select a.*
                from users t
                      join users a on a.OwnerId = t.id
                              and t.level = 3
                              and a.level = 6
                              and t.ibcode = '$airportCode'
                              and a.ibcode = '$airportCode'
            ",
            "company" => "
                select c.id,
                  c.company as company,
                  c.company as trading_name,
                  CONCAT_WS(' ',c.FirstName, c.LastName)  as contact,
                  CONCAT_WS(' ',c.Unit,c.StreetNo,c.Street,c.StreetType,c.Suburb,c.State,c.PostCode) as billing_address,
                  c.EmailAddress as email_address,
                  c.Telephone as office_number,
                  c.Mobile as mobile_number,
                  1 as created_by_user,
                  1 as created_by_visitor,
                  t.id as tenant,
                  a.id as tenant_agent,
                  0 as is_deleted,
                  null as cardCount,
                  3 as company_type
                from users t
                    left join users a on a.ownerid = t.id and a.level = 6 and a.ibcode = 'MBW'
                    join users c on c.ownerid in (t.id,a.id) and c.level = 4
                where t.ibcode = 'MBW'
                and t.level = 3
            ",
            'visitors' =>
                "select v.ID as id,
                v.FirstName as first_name,
                v.MiddleName as middle_name,
                v.LastName as last_name,
                v.EmailAddress as email,
                IFNULL(v.Mobile,v.Telephone) as contact_number,
                v.DateOfBirth as date_of_birth,
                v.Company as company,
                v.Password as password,
                v.Password as photo,
                v.Unit as contact_unit,
                v.StreetNo as contact_street_no,
                v.Street as contact_street_name,
                v.StreetType as contact_street_type,
                v.Suburb as contact_suburb,
                v.State as contact_state,
                v.PostCode as contact_post_code,
                v.Country as contact_country,
                ad.asic_number as asic_no,
                ad.asic_expiry as asic_expiry,

                idA.DocumentType as identification_type,
                idA.CountryIssue as identification_country_issued,
                idA.Number as identification_document_no,
                idA.Expiry as identification_document_expiry,
                idB.DocumentType as identification_name1,
                idB.CountryIssue as identification_country_issued1,
                idB.Number as identification_document_no1,
                idB.Expiry as identification_document_expiry1,
                idC.DocumentType as identification_name2,
                idC.CountryIssue as identification_country_issued2,
                idC.Number as identification_document_no2,
                idC.Expiry as identification_document_expiry2,
                t.id as tenant,
                ta.id as tenant_agent

                from users t
                  left join users ta on ta.ownerid = t.id and ta.level = 6
                  join users v on v.ownerid in (t.ID,ta.ID) and v.level in (5,10)
                  left join asic_data ad on ad.UserID = v.id
                  left join identifications idA
                               on v.id = idA.UserId
                               and idA.documenttype > ''
                               and idA.id = (select idAA.id
                                               from identifications idAA
                                               where idAA.UserID = v.id
                                               order by id desc
                                               limit 1)
                  left join identifications idB
                               on v.id = idB.UserId
                               and idB.documenttype > ''
                               and idB.id = (select idBB.id
                                               from identifications idBB
                                               where idBB.UserID = v.id
                                               order by id desc
                                               limit 1,1)
                   left join identifications idC
                               on v.id = idC.UserId
                               and idC.documenttype > ''
                               and idC.id = (select idCC.id
                                               from identifications idCC
                                               where idCC.UserID = v.id
                                               order by id desc
                                               limit 2,1)
                where t.IBCode = '$airportCode'
                ",

            'visits' =>
                "select v.id as id,
                       v.visitorid as visitor,
                       9 as card_type,
                       t.ID as card,
                       t.visitor_type as visitor_type,
                       v.ReasonNo as reason,
                       1 as visitor_status,
                       c.UserID as host,
                       c.UserID as created_by,
                       v.Date as date_in,
                       v.Time as time_in,
                       c.Date as date_out,
                       c.Time as time_out,
                       v.Date as date_check_in,
                       v.Time as time_check_in,
                       c.Date as date_check_out,
                       c.Time as time_check_out,
                       case
                        when v.IsClosed = 0 then 1
                        else 0
                       end as visit_status,
                       null as workstaton,
                       t.id as tenant,
                       a.id as tenant_agent,
                       0 as is_deleted,
                       c.Date as finish_date,
                       c.Time as finish_time,
                       c.DateCardReturned as card_returned_date,
                       n.Reason as negate_reason,
                       c.Date as visit_closed_date,
                       v.UserID as closed_by,
                       1 as asic_declaration,
                       1 as asic_verification,
                       null as company,
                       1 as is_listed
                from users t
                    left join users a on a.ownerid = t.id and a.level = 6 and t.ibcode = '$airportCode'
                    join users vu on vu.ownerId in (t.id,a.id) and level = 5
                    join log_visit v on v.VisitorId = uv.Id
                    join oc_set oc on v.SetID = oc.Id and oc.AirportCode = '$airportCode'
                    join card_type t on t.ID = oc.CID
                    left join close_visit c on v.ID = c.LoggedId
                    left join log_negate n on c.Id = n.closedid
                    left join visitor_company vc on v.id = vc.visitorId

              ",

        ];

    }



    public function cleanse(&$data)
    {
        for($i=0;$i<sizeof($data);$i++)
        {
            if($this->startsWith($data[$i],'="'))
            {
                $data[$i] = substr(2,strlen($data[$i])-3);
            }
            if(strpos($data[$i],"\\"))
            {
                $data[$i] = str_replace("\\","",$data[$i]);
            }
        }
        return $data;
    }

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }




}