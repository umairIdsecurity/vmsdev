<?php

class HelpDeskContents 
{
     public $helpdesk_group=array(
	     1=>'Visits',
		 2=>'Basic',     
	 );
	 
	 public $helpdesk=array(
	     1=>array('1',"What is Saved Applicants?","This is a list of applications that have gotten to the first step of the Add New Visitor process and have been saved to continue in the future. Also contained in this list is the individuals that have been added to the system through the Bulk Upload process. To continue with one of these, click on the 'Continue Application' link and you will be taken to step 2 of the application process."),
		 
		 2=>array('1',"What is the Non-Returned VICs list?","This is the list of VICs that have been given out to individuals at your airport but expired more than 24 hours ago. If the VIC has been returned then you just need to view the visit, change the card option to returned, and close the visit. If the VIC has been lost then the person who lost it will be required to fill out and sign a Statutory Declaration that they have lost it and return it to you before the visit can be closed and the person can apply for another VIC. If the VIC has been stolen then a police report must be filed and you must be provided with a copy of the police report or the police report number before the visit can be closed and the person can apply for another VIC."),  
		 
		 3=>array('2',"What is the VIC Holder Detail Page and how do I get to it?","The VIC Holder Detail page contains the information of an individual VIC, this page:
                     
                     <ul style=\"  margin-left: 30px;color: #6c7d8e;\">                
<li>Has a view of the VIC with option to go back and change the photo.</li>
<li>Displays the applicant's number of visits at your airport.</li>
<li>Displays the applicant's total number of visits at all airports registered with IDS.</li>
<li>Contains the process for verifying visit information, activating visit and printing the VIC.</li>
<li>Prints VIC with accordance to regulatory requirements, including unique identifier, VIC number, name of applicant and Issuing Body code. Photograph will be printed on Multi-Day cards. The software will allow a photo to be printed on Same-Day VIC, if no photo is provided then \"NO PHOTO REQUIRED\" will be printed on the card.</li>
<li>Contains process for cancelling and closing a visit. A visit can be cancelled up until the proposed date out on the VIC. When closing a visit the date the actual visit has ended and the date of return of VIC must be entered here, if VIC is lost or stolen the system will prompt the operator to upload statutory declaration or police report or provide a police report number.</li>
<li>Displays closed visit history of the VIC holder at the bottom of the page.</li>
<li>The VIC Holder Detail page is the last page that you are taken to when you are logging a new visit, you can also go back to this page later by going to the Active Visits page, finding the VIC you wish to view and pressing the View link
</li>
</ul>"), 
  
       4=>array('2',"What is the Non-Returned VICs list?","This is the list of VICs that have been given out to individuals at your airport but expired more than 24 hours ago. If the VIC has been returned then you just need to view the visit, change the card option to returned, and close the visit. If the VIC has been lost then the person who lost it will be required to fill out and sign a Statutory Declaration that they have lost it and return it to you before the visit can be closed and the person can apply for another VIC. If the VIC has been stolen then a police report must be filed and you must be provided with a copy of the police report or the police report number before the visit can be closed and the person can apply for another VIC."),  
	 );
	 
}

?>