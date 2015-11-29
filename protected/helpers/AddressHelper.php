<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 25/11/2015
 * Time: 12:49 PM
 */
class AddressHelper
{


    static $preDirections = "S W|SW|S E|SE|N W|NW|N E|NE|N|E|W|S|NORTH|SOUTH|EAST|WEST";
    static $suffixes = "CRT|CL|BVD|RISE|RETREAT|TCE|ESP|CLOSE|TURN|GATE|PK|PDE|GDNS|GV|GROVE|HGTS|RMBL|ALLEY|ALLEE|ALY|ALLEY|ALLY|ALY|ANEX|ANEX|ANX|ANNEX|ANNX|ANX|ARCADE|ARC|ARC|ARCADE|AVENUE|AV|AVE|AVE|AVEN|AVENU|AVENUE|AVN|AVNUE|BAYOU|BAYOO|BYU|BAYOU|BEACH|BCH|BCH|BEACH|BEND|BEND|BND|BND|BLUFF|BLF|BLF|BLUF|BLUFF|BLUFFS|BLUFFS|BLFS|BOTTOM|BOT|BTM|BTM|BOTTM|BOTTOM|BOULEVARD|BLVD|BLVD|BOUL|BOULEVARD|BOULV|BRANCH|BR|BR|BRNCH|BRANCH|BRIDGE|BRDGE|BRG|BRG|BRIDGE|BROOK|BRK|BRK|BROOK|BROOKS|BROOKS|BRKS|BURG|BURG|BG|BURGS|BURGS|BGS|BYPASS|BYP|BYP|BYPA|BYPAS|BYPASS|BYPS|CAMP|CAMP|CP|CP|CMP|CANYON|CANYN|CYN|CANYON|CNYN|CAPE|CAPE|CPE|CPE|CAUSEWAY|CAUSEWAY|CSWY|CAUSWA|CSWY|CENTER|CEN|CTR|CENT|CENTER|CENTR|CENTRE|CNTER|CNTR|CTR|CENTERS|CENTERS|CTRS|CIRCLE|CIR|CIR|CIRC|CIRCL|CIRCLE|CRCL|CRCLE|CIRCLES|CIRCLES|CIRS|CLIFF|CLF|CLF|CLIFF|CLIFFS|CLFS|CLFS|CLIFFS|CLUB|CLB|CLB|CLUB|COMMON|COMMON|CMN|COMMONS|COMMONS|CMNS|CORNER|COR|COR|CORNER|CORNERS|CORNERS|CORS|CORS|COURSE|COURSE|CRSE|CRSE|COURT|COURT|CT|CT|COURTS|COURTS|CTS|CTS|COVE|COVE|CV|CV|COVES|COVES|CVS|CREEK|CREEK|CRK|CRK|CRESCENT|CRESCENT|CRES|CRES|CRSENT|CRSNT|CREST|CREST|CRST|CROSSING|CROSSING|XING|CRSSNG|XING|CROSSROAD|CROSSROAD|XRD|CROSSROADS|CROSSROADS|XRDS|CURVE|CURVE|CURV|DALE|DALE|DL|DL|DAM|DAM|DM|DM|DIVIDE|DIV|DV|DIVIDE|DV|DVD|DRIVE|DR|DR|DRIV|DRIVE|DRV|DRIVES|DRIVES|DRS|ESTATE|EST|EST|ESTATE|ESTATES|ESTATES|ESTS|ESTS|EXPRESSWAY|EXP|EXPY|EXPR|EXPRESS|EXPRESSWAY|EXPW|EXPY|EXTENSION|EXT|EXT|EXTENSION|EXTN|EXTNSN|EXTENSIONS|EXTS|EXTS|FALL|FALL|FALL|FALLS|FALLS|FLS|FLS|FERRY|FERRY|FRY|FRRY|FRY|FIELD|FIELD|FLD|FLD|FIELDS|FIELDS|FLDS|FLDS|FLAT|FLAT|FLT|FLT|FLATS|FLATS|FLTS|FLTS|FORD|FORD|FRD|FRD|FORDS|FORDS|FRDS|FOREST|FOREST|FRST|FORESTS|FRST|FORGE|FORG|FRG|FORGE|FRG|FORGES|FORGES|FRGS|FORK|FORK|FRK|FRK|FORKS|FORKS|FRKS|FRKS|FORT|FORT|FT|FRT|FT|FREEWAY|FREEWAY|FWY|FREEWY|FRWAY|FRWY|FWY|GARDEN|GARDEN|GDN|GARDN|GRDEN|GRDN|GARDENS|GARDENS|GDNS|GDNS|GRDNS|GATEWAY|GATEWAY|GTWY|GATEWY|GATWAY|GTWAY|GTWY|GLEN|GLEN|GLN|GLN|GLENS|GLENS|GLNS|GREEN|GREEN|GRN|GRN|GREENS|GREENS|GRNS|GROVE|GROV|GRV|GROVE|GRV|GROVES|GROVES|GRVS|HARBOR|HARB|HBR|HARBOR|HARBR|HBR|HRBOR|HARBORS|HARBORS|HBRS|HAVEN|HAVEN|HVN|HVN|HEIGHTS|HT|HTS|HTS|HIGHWAY|HIGHWAY|HWY|HIGHWY|HIWAY|HIWY|HWAY|HWY|HILL|HILL|HL|HL|HILLS|HILLS|HLS|HLS|HOLLOW|HLLW|HOLW|HOLLOW|HOLLOWS|HOLW|HOLWS|INLET|INLT|INLT|ISLAND|IS|IS|ISLAND|ISLND|ISLANDS|ISLANDS|ISS|ISLNDS|ISS|ISLE|ISLE|ISLE|ISLES|JUNCTION|JCT|JCT|JCTION|JCTN|JUNCTION|JUNCTN|JUNCTON|JUNCTIONS|JCTNS|JCTS|JCTS|JUNCTIONS|KEY|KEY|KY|KY|KEYS|KEYS|KYS|KYS|KNOLL|KNL|KNL|KNOL|KNOLL|KNOLLS|KNLS|KNLS|KNOLLS|LAKE|LK|LK|LAKE|LAKES|LKS|LKS|LAKES|LAND|LAND|LAND|LANDING|LANDING|LNDG|LNDG|LNDNG|LANE|LANE|LN|LN|LIGHT|LGT|LGT|LIGHT|LIGHTS|LIGHTS|LGTS|LOAF|LF|LF|LOAF|LOCK|LCK|LCK|LOCK|LOCKS|LCKS|LCKS|LOCKS|LODGE|LDG|LDG|LDGE|LODG|LODGE|LOOP|LOOP|LOOP|LOOPS|MALL|MALL|MALL|MANOR|MNR|MNR|MANOR|MANORS|MANORS|MNRS|MNRS|MEADOW|MEADOW|MDW|MEADOWS|MDW|MDWS|MDWS|MEADOWS|MEDOWS|MEWS|MEWS|MEWS|MILL|MILL|ML|MILLS|MILLS|MLS|MISSION|MISSN|MSN|MSSN|MOTORWAY|MOTORWAY|MTWY|MOUNT|MNT|MT|MT|MOUNT|MOUNTAIN|MNTAIN|MTN|MNTN|MOUNTAIN|MOUNTIN|MTIN|MTN|MOUNTAINS|MNTNS|MTNS|MOUNTAINS|NECK|NCK|NCK|NECK|ORCHARD|ORCH|ORCH|ORCHARD|ORCHRD|OVAL|OVAL|OVAL|OVL|OVERPASS|OVERPASS|OPAS|PARK|PARK|PARK|PRK|PARKS|PARKS|PARK|PARKWAY|PARKWAY|PKWY|PARKWY|PKWAY|PKWY|PKY|PARKWAYS|PARKWAYS|PKWY|PKWYS|PASS|PASS|PASS|PASSAGE|PASSAGE|PSGE|PATH|PATH|PATH|PATHS|PIKE|PIKE|PIKE|PIKES|PINE|PINE|PNE|PINES|PINES|PNES|PNES|PLACE|PL|PL|PLAIN|PLAIN|PLN|PLN|PLAINS|PLAINS|PLNS|PLNS|PLAZA|PLAZA|PLZ|PLZ|PLZA|POINT|POINT|PT|PT|POINTS|POINTS|PTS|PTS|PORT|PORT|PRT|PRT|PORTS|PORTS|PRTS|PRTS|PRAIRIE|PR|PR|PRAIRIE|PRR|RADIAL|RAD|RADL|RADIAL|RADIEL|RADL|RAMP|RAMP|RAMP|RANCH|RANCH|RNCH|RANCHES|RNCH|RNCHS|RAPID|RAPID|RPD|RPD|RAPIDS|RAPIDS|RPDS|RPDS|REST|REST|RST|RST|RIDGE|RDG|RDG|RDGE|RIDGE|RIDGES|RDGS|RDGS|RIDGES|RIVER|RIV|RIV|RIVER|RVR|RIVR|ROAD|RD|RD|ROAD|ROADS|ROADS|RDS|RDS|ROUTE|ROUTE|RTE|ROW|ROW|ROW|RUE|RUE|RUE|RUN|RUN|RUN|SHOAL|SHL|SHL|SHOAL|SHOALS|SHLS|SHLS|SHOALS|SHORE|SHOAR|SHR|SHORE|SHR|SHORES|SHOARS|SHRS|SHORES|SHRS|SKYWAY|SKYWAY|SKWY|SPRING|SPG|SPG|SPNG|SPRING|SPRNG|SPRINGS|SPGS|SPGS|SPNGS|SPRINGS|SPRNGS|SPUR|SPUR|SPUR|SPURS|SPURS|SPUR|SQUARE|SQ|SQ|SQR|SQRE|SQU|SQUARE|SQUARES|SQRS|SQS|SQUARES|STATION|STA|STA|STATION|STATN|STN|STRAVENUE|STRA|STRA|STRAV|STRAVEN|STRAVENUE|STRAVN|STRVN|STRVNUE|STREAM|STREAM|STRM|STREME|STRM|STREET|STREET|ST|STRT|ST|STR|STREETS|STREETS|STS|SUMMIT|SMT|SMT|SUMIT|SUMITT|SUMMIT|TERRACE|TER|TER|TERR|TERRACE|THROUGHWAY|THROUGHWAY|TRWY|TRACE|TRACE|TRCE|TRACES|TRCE|TRACK|TRACK|TRAK|TRACKS|TRAK|TRK|TRKS|TRAFFICWAY|TRAFFICWAY|TRFY|TRAIL|TRAIL|TRL|TRAILS|TRL|TRLS|TRAILER|TRAILER|TRLR|TRLR|TRLRS|TUNNEL|TUNEL|TUNL|TUNL|TUNLS|TUNNEL|TUNNELS|TUNNL|TURNPIKE|TRNPK|TPKE|TURNPIKE|TURNPK|UNDERPASS|UNDERPASS|UPAS|UNION|UN|UN|UNION|UNIONS|UNIONS|UNS|VALLEY|VALLEY|VLY|VALLY|VLLY|VLY|VALLEYS|VALLEYS|VLYS|VLYS|VIADUCT|VDCT|VIA|VIA|VIADCT|VIADUCT|VIEW|VIEW|VW|VW|VIEWS|VIEWS|VWS|VWS|VILLAGE|VILL|VLG|VILLAG|VILLAGE|VILLG|VILLIAGE|VLG|VILLAGES|VILLAGES|VLGS|VLGS|VILLE|VILLE|VL|VL|VISTA|VIS|VIS|VIST|VISTA|VST|VSTA|WALK|WALK|WALK|WALKS|WALKS|WALK|WALL|WALL|WALL|WAY|WY|WAY|WAY|WAYS|WAYS|WAYS|WELL|WELL|WL|WELLS|WELLS|WLS";

    static $unitDesignators = "APARTMENT|APT|BUILDING|BLDG|FLOOR|FL|SUITE|STE|UNIT|UNIT|ROOM|RM|DEPARTMENT|DEPT|SPC|LEVEL|LVL";
    static $suburbIndex = null;
    static $postCodeIndex = null;


    public static function parse($fullAddress){

        if(AddressHelper::$suburbIndex==null){
            AddressHelper::getSuburbs();
        }

        $fullAddress = strtoupper($fullAddress);
        $fullAddress = str_replace("\n"," ",$fullAddress);
        $fullAddress = str_replace("\r"," ",$fullAddress);
        $suburb = AddressHelper::matchSuburb($fullAddress);

        if($suburb!=null) {
            $address = rtrim(substr($fullAddress, 0, strpos($fullAddress, $suburb['Suburb'])), ',');
        } else {
            // try to match with google spaces
            $result = AddressHelper::parseFromGoogleSpaces($fullAddress);
            if($result!=null)
            {
                return $result;
            }
            $address = $fullAddress;
        }
        $result =  AddressHelper::regexParse($address);

        if($suburb!=null){
            $result = array_merge($result,$suburb);
        } else {
            $dummy = ['Suburb'=>'Unknown','State'=>'WA','PostCode'=>'0000'];
            $result = array_merge($result,$dummy);
        }

        return $result;



        return $result;


    }
    public static function regexParse($address){
        $pUnitNo = "([0-9]{1,4}[a-zA-Z]{0,1})";
        $pUnit = "(?<Unit>((({2}) $pUnitNo) )|($pUnitNo\/))?";
        $pPOBox = "(?<POBox>((PO|P O) (BX|BOX) [0-9]*))?";
        $pStreetNumber ="((?<StreetNumber>((LOT )?$pUnitNo)?)(?: ))*";
        $pPreDirection = "((?<PreDirection>({0}))(?! ({1}) ($|({2})))(?: ))?";
        $pStreetName = "(?<StreetName>(.* ))?";
        $pstreetType = "(?<StreetType>(({1})))";

        $fullPattern = "(".$pUnit.$pStreetNumber.$pStreetName.$pstreetType.")|(".$pPOBox.")";

        $fullPattern = str_replace("{0}",AddressHelper::$preDirections,$fullPattern);
        $fullPattern = str_replace("{1}",AddressHelper::$suffixes,$fullPattern);
        $fullPattern = str_replace("{2}",AddressHelper::$unitDesignators,$fullPattern);

        $matches = [];
        preg_match( "/". $fullPattern."/" , strtoupper($address),$matches );

        if($matches['Unit']!=null){
            $matches['Unit'] = str_replace('\\','',str_replace('/','',$matches['Unit']));
        }
        $result = [];
        if(isset($matches['Unit'])) $result['Unit'] = $matches['Unit'];
        if(isset($matches['POBox'])) $result['POBox'] = $matches['POBox'];
        if(isset($matches['StreetNumber'])) $result['StreetNumber'] = $matches['StreetNumber'];
        if(isset($matches['StreetName'])) $result['StreetName'] = $matches['StreetName'];
        if(isset($matches['StreetType'])) $result['StreetType'] = $matches['StreetType'];
        return $result;

    }

    public static function getSuburbs(){
        $fileName = Yii::app()->basePath."/helpers/aus-postcodes.csv";
        $rows = new CSVFileHelper();
        $rows->open($fileName);
        $suburbs = [];
        //$postCodes = [];
        while($rows->hasMore()){

            $row = $rows->nextRow();

            if(!isset($row['type'])){
                echo 'broken here ';
                continue;
            }
            if($row['type']=='Delivery Area') {

                $data = [$row['suburb'],$row['state'],$row['postcode']];
                //$postCodes[$row['postcode']] = $data;

                $words = explode(' ',strtoupper($row['suburb']));

                $p = &$suburbs;
                for ($i=0;$i < sizeof($words) - 1; $i++) {
                    if(!isset($p[$words[$i]])){
                        $p[$words[$i]]=[];
                    }
                    $p = &$p[$words[$i]];
                }

                $p[$words[sizeof($words)-1]]['+'] = $data;

            }

        }
        //AddressHelper::$postCodeIndex = &$postCodes;
        AddressHelper::$suburbIndex = &$suburbs;
    }

    public static function matchSuburb($address){

        // match on post code first
        $parts=explode(' ',str_replace(',',' ',trim($address)));

        $parts[] = "@@@";
        for($a=sizeof($parts)-1;$a>=0;$a--){
            if(isset(AddressHelper::$suburbIndex[$parts[$a]])){
                $startWord = $parts[$a];
                $s = AddressHelper::$suburbIndex[$parts[$a]];
                for($b=$a+1;$b<sizeof($parts);$b++){
                    $compWord = $parts[$b];
                    if(isset($s[$parts[$b]])){
                        $s = $s[$parts[$b]];
                        continue;
                    } else if(isset($s['+'])){
                        $result =  $s['+'];
                        return [
                            'Suburb'=>$result[0],
                            'State'=>$result[1],
                            'PostCode'=>$result[2]
                        ];
                    }
                }
            }
        }
    }





    public static function parseFromGoogleSpaces($address){

        // find the place
        $parameters = [
            'query'=>$address,
            'key'=>'AIzaSyAvBlpgYzEpAr3b2Ufaefv4niT__0osyXo'
        ];
        $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?".http_build_query($parameters);
        $response = file_get_contents($url);
        if($response==null) return null;
        $json = json_decode($response);
        if($json->status!="OK" || sizeof($json->results)==0) return null;

        // find the place details
        $parameters = [
            'placeid' => $json->results[0]->place_id,
            'key' => 'AIzaSyAvBlpgYzEpAr3b2Ufaefv4niT__0osyXo'
        ];

        $url = "https://maps.googleapis.com/maps/api/place/details/json?" . http_build_query($parameters);
        $response = file_get_contents($url);
        if($response==null) return null;
        $json = json_decode($response);
        if($json->status!="OK" || $json->result==null) return null;

        $raw = [];
        foreach($json->result->address_components as $part)
        {
            $raw[$part->types[0]] = $part->short_name;
        }
        $result = [];
        $streetAddress = ((isset($raw['subpremise']) && $raw['subpremise']>'')?$raw['subpremise']."/":"").
            ((isset($raw['street_number']) && $raw['street_number']>'')?$raw['street_number']." ":" ").
            ((isset($raw['route']) && $raw['route']>'')?$raw['route']." ":" ");

        $result = AddressHelper::regexParse($streetAddress);

        if(isset($raw['administrative_area_level_1'])){$result['State']=$raw['administrative_area_level_1'];}
        if(isset($raw['street_number'])){$result['StreetNumber']=$raw['street_number'];}
        //if(isset($raw['route']))        {$result['StreetName']=$raw['route'];}
        if(isset($raw['locality']))     {$result['Suburb']=$raw['locality'];}
        if(isset($raw['country']))      {$result['Country']=$raw['country'];}
        if(isset($raw['postal_code']))  {$result['PostCode']=$raw['postal_code'];}
        if(isset($raw['subpremise'])){$result['Unit']=$raw['subpremise'];}

        return $result;

    }



}