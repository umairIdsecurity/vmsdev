<?php

Yii::import('ext.tools.IdempotentDbOperation');

class m150507_091726_issue_175 extends CDbMigration
{
    public function safeUp()
    {
        $idempotent = new IdempotentDbOperation($this);

        $idempotent->dropAndAddColumn('visitor_card_status',
            'profile_type',
            "enum('VIC','ASIC', 'CORPORATE') NOT NULL DEFAULT 'CORPORATE'"
        );

        $countryDefinition = "
CREATE TABLE IF NOT EXISTS `country` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`code` char(2) NOT NULL DEFAULT '',
	`name` varchar(45) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;
       ";

        $idempotent->createTable('country', $countryDefinition, $this->countryData);

        $idempotent->dropAndAddColumn(
            'visitor', 'profile_type', "enum('VIC','ASIC', 'CORPORATE') NOT NULL DEFAULT 'CORPORATE'"
        );

        $idempotent->addColumn('visitor', 'middle_name', "varchar(50) DEFAULT NULL AFTER `first_name`");
        $idempotent->dropAndAddColumn(
            'visitor', 'identification_type', "enum('PASSPORT','DRIVERS_LICENSE', 'PROOF_OF_AGE') DEFAULT NULL"
        );
        $idempotent->addColumn(
            'visitor', 'identification_country_issued', "int(5) DEFAULT NULL",
            "ADD CONSTRAINT `identification_country_fk` FOREIGN KEY (`identification_country_issued`) REFERENCES `country` (`id`)"
        );
        $idempotent->addColumn('visitor', 'identification_document_no', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_document_expiry', "date DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_alternate_document_name1', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_alternate_document_no1', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_alternate_document_expiry1', "date DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_alternate_document_name2', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_alternate_document_no2', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'identification_alternate_document_expiry2', "date DEFAULT NULL");
        $idempotent->addColumn('visitor', 'contact_unit', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'contact_street_no', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'contact_street_name', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'contact_street_type', "enum('ALLY', 'APP', 'ARC', 'AVE', 'BLVD', 'BROW', 'BYPA', 'CWAY', 'CCT', 'CIRC', 'CL', 'CPSE', 'CNR', 'CT', 'CRES', 'CRS', 'DR', 'END', 'EESP', 'FLAT', 'FWAY', 'FRNT', 'GDNS', 'GLD', 'GLEN', 'GRN', 'GR', 'HTS', 'HWY', 'LANE', 'LINK', 'LOOP', 'MALL', 'MEWS', 'PCKT', 'PDE', 'PARK', 'PKWY', 'PL', 'PROM', 'RES', 'RDGE', 'RISE', 'RD', 'ROW', 'SQ', 'ST', 'STRP', 'TARN', 'TCE', 'FARETFRE', 'TRAC', 'TWAY', 'VIEW', 'VSTA', 'WALK', 'WWAY', 'WAY', 'YARD') DEFAULT NULL");
        $idempotent->addColumn('visitor', 'contact_suburb', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn(
            'visitor', 'contact_state', "enum('ACT', 'NSW', 'NT', 'Qld', 'SA', 'Tas', 'Vic', 'WA') DEFAULT NULL"
        );
        $idempotent->addColumn(
            'visitor', 'contact_country', "int(5) DEFAULT NULL",
            "ADD CONSTRAINT `contact_country_fk` FOREIGN KEY (`contact_country`) REFERENCES `country` (`id`)"
        );
    }

    public function safeDown()
    {
        $idempotent = new IdempotentDbOperation($this);


        $idempotent->modifyColumn(
            'visitor_card_status', 'profile_type', "enum('VIC','ASIC') NOT NULL DEFAULT 'VIC'"
        );

        $idempotent->modifyColumn(
            'visitor', 'profile_type', "enum('VIC','ASIC') NOT NULL DEFAULT 'VIC'"
        );
        $idempotent->dropColumn('visitor', 'middle_name');
        $idempotent->dropColumn('visitor', 'identification_type');
        $idempotent->dropColumn('visitor', 'identification_country_issued', 'identification_country_fk');
        $idempotent->dropColumn('visitor', 'identification_document_no');
        $idempotent->dropColumn('visitor', 'identification_document_expiry');
        $idempotent->dropColumn('visitor', 'identification_alternate_document_name1');
        $idempotent->dropColumn('visitor', 'identification_alternate_document_no1');
        $idempotent->dropColumn('visitor', 'identification_alternate_document_expiry1');
        $idempotent->dropColumn('visitor', 'identification_alternate_document_name2');
        $idempotent->dropColumn('visitor', 'identification_alternate_document_no2');
        $idempotent->dropColumn('visitor', 'identification_alternate_document_expiry2');
        $idempotent->dropColumn('visitor', 'contact_unit');
        $idempotent->dropColumn('visitor', 'contact_street_no');
        $idempotent->dropColumn('visitor', 'contact_street_name');
        $idempotent->dropColumn('visitor', 'contact_street_type');
        $idempotent->dropColumn('visitor', 'contact_suburb');
        $idempotent->dropColumn('visitor', 'contact_state');
        $idempotent->dropColumn('visitor', 'contact_country', 'contact_country_fk');

        $this->execute("DROP TABLE IF EXISTS `country`;");
    }

    protected $countryData = "
INSERT INTO `country` (`code`, `name`) VALUES
('AD', 'Andorra'),
('AE', 'United Arab Emirates'),
('AF', 'Afghanistan'),
('AG', 'Antigua and Barbuda'),
('AI', 'Anguilla'),
('AL', 'Albania'),
('AM', 'Armenia'),
('AO', 'Angola'),
('AQ', 'Antarctica'),
('AR', 'Argentina'),
('AS', 'American Samoa'),
('AT', 'Austria'),
('AU', 'Australia'),
('AW', 'Aruba'),
('AX', 'Åland'),
('AZ', 'Azerbaijan'),
('BA', 'Bosnia and Herzegovina'),
('BB', 'Barbados'),
('BD', 'Bangladesh'),
('BE', 'Belgium'),
('BF', 'Burkina Faso'),
('BG', 'Bulgaria'),
('BH', 'Bahrain'),
('BI', 'Burundi'),
('BJ', 'Benin'),
('BL', 'Saint Barthélemy'),
('BM', 'Bermuda'),
('BN', 'Brunei'),
('BO', 'Bolivia'),
('BQ', 'Bonaire'),
('BR', 'Brazil'),
('BS', 'Bahamas'),
('BT', 'Bhutan'),
('BV', 'Bouvet Island'),
('BW', 'Botswana'),
('BY', 'Belarus'),
('BZ', 'Belize'),
('CA', 'Canada'),
('CC', 'Cocos [Keeling] Islands'),
('CD', 'Democratic Republic of the Congo'),
('CF', 'Central African Republic'),
('CG', 'Republic of the Congo'),
('CH', 'Switzerland'),
('CI', 'Ivory Coast'),
('CK', 'Cook Islands'),
('CL', 'Chile'),
('CM', 'Cameroon'),
('CN', 'China'),
('CO', 'Colombia'),
('CR', 'Costa Rica'),
('CU', 'Cuba'),
('CV', 'Cape Verde'),
('CW', 'Curacao'),
('CX', 'Christmas Island'),
('CY', 'Cyprus'),
('CZ', 'Czech Republic'),
('DE', 'Germany'),
('DJ', 'Djibouti'),
('DK', 'Denmark'),
('DM', 'Dominica'),
('DO', 'Dominican Republic'),
('DZ', 'Algeria'),
('EC', 'Ecuador'),
('EE', 'Estonia'),
('EG', 'Egypt'),
('EH', 'Western Sahara'),
('ER', 'Eritrea'),
('ES', 'Spain'),
('ET', 'Ethiopia'),
('FI', 'Finland'),
('FJ', 'Fiji'),
('FK', 'Falkland Islands'),
('FM', 'Micronesia'),
('FO', 'Faroe Islands'),
('FR', 'France'),
('GA', 'Gabon'),
('GB', 'United Kingdom'),
('GD', 'Grenada'),
('GE', 'Georgia'),
('GF', 'French Guiana'),
('GG', 'Guernsey'),
('GH', 'Ghana'),
('GI', 'Gibraltar'),
('GL', 'Greenland'),
('GM', 'Gambia'),
('GN', 'Guinea'),
('GP', 'Guadeloupe'),
('GQ', 'Equatorial Guinea'),
('GR', 'Greece'),
('GS', 'South Georgia and the South Sandwich Islands'),
('GT', 'Guatemala'),
('GU', 'Guam'),
('GW', 'Guinea-Bissau'),
('GY', 'Guyana'),
('HK', 'Hong Kong'),
('HM', 'Heard Island and McDonald Islands'),
('HN', 'Honduras'),
('HR', 'Croatia'),
('HT', 'Haiti'),
('HU', 'Hungary'),
('ID', 'Indonesia'),
('IE', 'Ireland'),
('IL', 'Israel'),
('IM', 'Isle of Man'),
('IN', 'India'),
('IO', 'British Indian Ocean Territory'),
('IQ', 'Iraq'),
('IR', 'Iran'),
('IS', 'Iceland'),
('IT', 'Italy'),
('JE', 'Jersey'),
('JM', 'Jamaica'),
('JO', 'Jordan'),
('JP', 'Japan'),
('KE', 'Kenya'),
('KG', 'Kyrgyzstan'),
('KH', 'Cambodia'),
('KI', 'Kiribati'),
('KM', 'Comoros'),
('KN', 'Saint Kitts and Nevis'),
('KP', 'North Korea'),
('KR', 'South Korea'),
('KW', 'Kuwait'),
('KY', 'Cayman Islands'),
('KZ', 'Kazakhstan'),
('LA', 'Laos'),
('LB', 'Lebanon'),
('LC', 'Saint Lucia'),
('LI', 'Liechtenstein'),
('LK', 'Sri Lanka'),
('LR', 'Liberia'),
('LS', 'Lesotho'),
('LT', 'Lithuania'),
('LU', 'Luxembourg'),
('LV', 'Latvia'),
('LY', 'Libya'),
('MA', 'Morocco'),
('MC', 'Monaco'),
('MD', 'Moldova'),
('ME', 'Montenegro'),
('MF', 'Saint Martin'),
('MG', 'Madagascar'),
('MH', 'Marshall Islands'),
('MK', 'Macedonia'),
('ML', 'Mali'),
('MM', 'Myanmar [Burma]'),
('MN', 'Mongolia'),
('MO', 'Macao'),
('MP', 'Northern Mariana Islands'),
('MQ', 'Martinique'),
('MR', 'Mauritania'),
('MS', 'Montserrat'),
('MT', 'Malta'),
('MU', 'Mauritius'),
('MV', 'Maldives'),
('MW', 'Malawi'),
('MX', 'Mexico'),
('MY', 'Malaysia'),
('MZ', 'Mozambique'),
('NA', 'Namibia'),
('NC', 'New Caledonia'),
('NE', 'Niger'),
('NF', 'Norfolk Island'),
('NG', 'Nigeria'),
('NI', 'Nicaragua'),
('NL', 'Netherlands'),
('NO', 'Norway'),
('NP', 'Nepal'),
('NR', 'Nauru'),
('NU', 'Niue'),
('NZ', 'New Zealand'),
('OM', 'Oman'),
('PA', 'Panama'),
('PE', 'Peru'),
('PF', 'French Polynesia'),
('PG', 'Papua New Guinea'),
('PH', 'Philippines'),
('PK', 'Pakistan'),
('PL', 'Poland'),
('PM', 'Saint Pierre and Miquelon'),
('PN', 'Pitcairn Islands'),
('PR', 'Puerto Rico'),
('PS', 'Palestine'),
('PT', 'Portugal'),
('PW', 'Palau'),
('PY', 'Paraguay'),
('QA', 'Qatar'),
('RE', 'Réunion'),
('RO', 'Romania'),
('RS', 'Serbia'),
('RU', 'Russia'),
('RW', 'Rwanda'),
('SA', 'Saudi Arabia'),
('SB', 'Solomon Islands'),
('SC', 'Seychelles'),
('SD', 'Sudan'),
('SE', 'Sweden'),
('SG', 'Singapore'),
('SH', 'Saint Helena'),
('SI', 'Slovenia'),
('SJ', 'Svalbard and Jan Mayen'),
('SK', 'Slovakia'),
('SL', 'Sierra Leone'),
('SM', 'San Marino'),
('SN', 'Senegal'),
('SO', 'Somalia'),
('SR', 'Suriname'),
('SS', 'South Sudan'),
('ST', 'São Tomé and Príncipe'),
('SV', 'El Salvador'),
('SX', 'Sint Maarten'),
('SY', 'Syria'),
('SZ', 'Swaziland'),
('TC', 'Turks and Caicos Islands'),
('TD', 'Chad'),
('TF', 'French Southern Territories'),
('TG', 'Togo'),
('TH', 'Thailand'),
('TJ', 'Tajikistan'),
('TK', 'Tokelau'),
('TL', 'East Timor'),
('TM', 'Turkmenistan'),
('TN', 'Tunisia'),
('TO', 'Tonga'),
('TR', 'Turkey'),
('TT', 'Trinidad and Tobago'),
('TV', 'Tuvalu'),
('TW', 'Taiwan'),
('TZ', 'Tanzania'),
('UA', 'Ukraine'),
('UG', 'Uganda'),
('UM', 'U.S. Minor Outlying Islands'),
('US', 'United States'),
('UY', 'Uruguay'),
('UZ', 'Uzbekistan'),
('VA', 'Vatican City'),
('VC', 'Saint Vincent and the Grenadines'),
('VE', 'Venezuela'),
('VG', 'British Virgin Islands'),
('VI', 'U.S. Virgin Islands'),
('VN', 'Vietnam'),
('VU', 'Vanuatu'),
('WF', 'Wallis and Futuna'),
('WS', 'Samoa'),
('XK', 'Kosovo'),
('YE', 'Yemen'),
('YT', 'Mayotte'),
('ZA', 'South Africa'),
('ZM', 'Zambia'),
('ZW', 'Zimbabwe');
        ";
}