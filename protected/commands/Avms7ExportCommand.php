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
        $tenant = 1;
        $tenant_agent = 1;
        $workstation = 1;
        $queries = [
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
                idC.Expiry as identification_document_expiry2
                from users ib
                  join users v on v.ownerid = ib.ID
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
                where ib.IBCode = '$airportCode'
                and v.level = 5 ",
                //"and ib.level = 1 ",

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

              ",

        ];

        foreach($queries as $name=>$sql){
            echo "\r\n".$sql;
        }

    }


    public function GetRow($sql){
        
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