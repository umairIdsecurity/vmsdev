<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 29/10/2015
 * Time: 9:56 PM
 */
class Avms7ImportCommand extends CConsoleCommand
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
        $queries = [
            'visitors' =>
                "select v.ID as id, ".
                "v.FirstName as first_name, ".
                "v.MiddleName as middle_name, ".
                "v.LastName as last_name, ".
                "v.EmailAddress as email ".
                "IFNULL(v.Mobile,v.Telephone) as contact_number, ".
                "v.DateOfBirth as date_of_birth, ".
                "v.CompanyName as company, ".
                "v.Password as password, ".
                "v.Password as photo, ".
                "v.Unit as contact_unit, ".
                "v.StreetNo as contact_street_no, ".
                "v.Street as contact_street_name, ".
                "v.StreetType as contact_street_type, ".
                "v.Suburb as contact_suburb, ".
                "v.State as contact_state, ".
                "v.PostCode as contact_post_code. ".
                "v.Country as contact_country, ".
                "a.asic_number as asic_no, ".
                "a.asic_expiry as asic_expiry, ".
                "i.DocumentType as identification_type, ".
                "i.CountryIssue as identification_country_issued, ".
                "i.Expiry as identification_expiry, ".
                "i.Expiry as identification_expiry, ".


                "from users ib ".
                "   join users v on v.ownerid = ib.ID ".
                "   join asic_data ad v on v.id = ad.UserID ".
                "   join identification i v on i.UserID. = v.ID ".
                "where ib.IBCode = '$airportCode' ".
                "and v.level = 5".
                "",

            'visits' =>
                "select lv.* from log_visit lv join oc_set oc on lv.SetID = oc.Id and oc.AirportCode = '$airportCode'",
        ];
    }

    public function GetVisitor($row){
        $v = [];
        $v['id']=$row['ID'];
        $v['']=$row['Card No.'];
        $v['']=$row['Manual Card No.'];
        $v['']=$row['AirportCode'];
        $v['']=$row['FirstName'];
        $v['']=$row['LastName'];
        $v['']=$row['DateOfBirth'];
        $v['']=$row['Mobile'];
        $v['']=$row['StreetNo'];
        $v['']=$row['Street'];
        $v['']=$row['StreetType'];
        $v['']=$row['Suburb'];
        $v['']=$row['State'];
        $v['']=$row['Postcode'];
        $v['']=$row['Purpose of visit'];
        $v['']=$row['CompanyName'];
        $v['']=$row['ContactEmail'];
        $v['']=$row['ContactPerson'];
        $v['']=$row['ContactPhone'];
        $v['']=$row['Date of issue'];
        $v['']=$row['Date of its expiry'];
        $v['']=$row['Date of return or lost'];
        $v['']=$row['Name of ASIC Supervisor'];
        $v['']=$row['ASIC ID Number'];
        $v['']=$row['ASIC expiry date'];
        $v['']=$row['DocumentType'];
        $v['']=$row['Number'];
        $v['']=$row['Expiry'];
        $v['']=$row['Name of ASIC Sponsor'];
        $v['']=$row['ASIC Sponsor ID Number'];
        $v['']=$row['ASIC Sponsor expiry date'];
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