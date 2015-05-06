<?php
$this->pageTitle=Yii::app()->name . ' - Help Desk';
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase. '/js/helpdesk.js');
/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
?>
<div >
<h1>Help Desk</h1>




<div class="row buttons" style="margin-top: 30px;">
         <input type="text" name="txt_search"  id="txt_search" value="" placeholder="Example: How do I add a new visit?" style="margin-bottom: 0;
  margin-left: 50px; width: 500px;"  />
		<input type="submit" name="searchFaq" id="searchFaq" value="Search" class="actionForward"  />
        <input type="submit" name="showAllFaq" id="showAllFaq"  value="Show All"   />
        <input type="submit" name="askAQuestion" value="Ask a Quesion" onclick="window.location.href='<?php echo Yii::app()->createUrl("/dashboard/contactsupport"); ?>'"  />
	</div>




<section class="help-desk">
	
  
	<div class="help-desk-items">
	
    	<ul id="basics" class="help-desk-group">
			<li class="help-desk-title"><h2>Basics</h2></li>
            
			<li>
				<a class="help-desk-trigger" href="#0">Can I backdate visits?</a>
				<div class="help-desk-content">
					<p>Visits being entered into the IDS AVMS cannot be backdated. We are currently working on a function to allow users to import information about previous visits that will go towards individual's visit counts. This will be up shortly.
                    </p>
				</div> 
			</li>

			<li>
				<a class="help-desk-trigger" href="#0">How do I cancel a visit?</a>
				<div class="help-desk-content">
					<p>If you pre-register a visit for an individual but something was entered incorrectly or they are no longer visiting the airport you may cancel the visit.</p>
				</div> <!-- help-desk-content -->
			</li>

			<li>
            
				<a class="help-desk-trigger" href="#0">How do I add a new visit?</a>
				
                <div class="help-desk-content" >
					 <p>Click on 'Add New Visitor' link in Main Menu on left hand side of page.<br/><br/>
                        Select card type you require at step one. 
<br/><br/>
Enter required information at all other steps (after step 2 you may click 'Save' if you wish to close it and come back to it later - when you want to come back to it, the saved visit can be located in the Saved Applicants list). Information you are asked to provide includes:<br/>
<ul style="  margin-left: 30px;color: #6c7d8e;">
      <li>Full name.</li>
      <li>Address.</li>
      <li>Date of birth.</li>
      <li>Contact Email - multiple users cannot register with the same email address.</li>
      <li>Contact phone number.</li>
      <li> 
          Proof of identification, this can be either passport information or two other forms of identification. There is an option to upload copies of documentation and OCR and other scanning technologies can be implemented here also.
      </li>
      <li>
           Operational need information including the company name, company contact, mobile and email address. There is also an option at the bottom of the page to upload documentation of proof of operational need.
      </li>
      <li>ASIC Sponsor and ASIC Supervisor details.</li>
      <li>
          Tick boxes to declare that the applicant has not been refused an ASIC or had one suspended due to a criminal record and to declare the applicant has not been issued a VIC at the proposed airport for more than 28 days in 12 months.
      </li>
      <li>
          Date and time of proposed visit including proposed date out and airport. Agents may have more than one airport in their pull-down menu.
      </li>
      <li>
          Photo, if the VIC requires one. There is a photo upload tool provided for this. Images can be up to 1000 pixels wide and 2mb in size, with a format of .jpg, .png or .gif. Once uploaded the image can be cropped.
       </li>
</ul>
</p>
<p>
If you are pre-registering a visit then at the end of step 4 click 'Pre-Register Only' button. 
<br/>
Check visit date and proposed time in then press "Confirm". 
<br/>
Check the VIC Holder Details, the Operational Needs and Declaration and ASIC Supervisor details. If they aren't correct then press the "Update" button located at the bottom of the section you wish to update. Also double check you are happy with the photo you selected (if you selected one), if not then press the 'Change/Edit Image' button. Once the information has been check select "Yes" under "The VIC holders identification, Operational Need & ASIC Supervisor have been verified?". 
<br/>
If you wish to now activate the visit press "Activate Visit", if you press cancel then the visit will be stored in the 'Log Previous VIC Holder' list. 
<br/>
Once the visit is activated you may print the card by pressing "Print Card". 
<br/>
Visit should now show in the Active Visits list.</p>
				</div>
                 <!-- help-desk-content -->
			</li>

			<li>
				<a class="help-desk-trigger" href="#0">What are Active Visits?</a>
				<div class="help-desk-content">
					<p>
This is the front page of the VIC Issuing Panel, it displays all visits that have been activated and not closed. A visit highlights in red if the card has reached its expiry without being closed and is then moved to the Non-Returned VICs list after 24 hours. 
From here you can go into your active visits and change certain information. You can also close the visit from here and cancel it (up to the point that the VIC is supposed to be returned).</p>
				</div> <!-- help-desk-content -->
			</li>
            
            <li>
				<a class="help-desk-trigger" href="#0">What are Pre-Registered Visits?</a>
				<div class="help-desk-content">
					<p>
Displays pre-registered visits logged via the operator of the VIC Issuing Panel or via other Pre-Registration tools. If a visit is not activated within 48 hours of pre-registration date and time the details of the visit will no longer display in this section. Companies and individuals are able to Pre-Register a visit but are not able to print the card or see the unique card number.</p>
				</div> <!-- help-desk-content -->
			</li>
            
            <li>
				<a class="help-desk-trigger" href="#0">What is the VIC Holder Detail Page and how do I get to it?</a>
				<div class="help-desk-content"><p>The VIC Holder Detail page contains the information of an individual VIC, this page:
                     
                     <ul style="  margin-left: 30px;color: #6c7d8e;">                
<li>Has a view of the VIC with option to go back and change the photo.</li>
<li>Displays the applicant's number of visits at your airport.</li>
<li>Displays the applicant's total number of visits at all airports registered with IDS.</li>
<li>Contains the process for verifying visit information, activating visit and printing the VIC.</li>
<li>Prints VIC with accordance to regulatory requirements, including unique identifier, VIC number, name of applicant and Issuing Body code. Photograph will be printed on Multi-Day cards. The software will allow a photo to be printed on Same-Day VIC, if no photo is provided then "NO PHOTO REQUIRED" will be printed on the card.</li>
<li>Contains process for cancelling and closing a visit. A visit can be cancelled up until the proposed date out on the VIC. When closing a visit the date the actual visit has ended and the date of return of VIC must be entered here, if VIC is lost or stolen the system will prompt the operator to upload statutory declaration or police report or provide a police report number.</li>
<li>Displays closed visit history of the VIC holder at the bottom of the page.</li>
<li>The VIC Holder Detail page is the last page that you are taken to when you are logging a new visit, you can also go back to this page later by going to the Active Visits page, finding the VIC you wish to view and pressing the View link
</li>
</ul>
                  </p>
				</div> <!-- help-desk-content -->
			</li>
            
            <li>
				<a class="help-desk-trigger" href="#0">What is the Non-Returned VICs list?</a>
				<div class="help-desk-content">
					<p>
This is the list of VICs that have been given out to individuals at your airport but expired more than 24 hours ago. If the VIC has been returned then you just need to view the visit, change the card option to returned, and close the visit. If the VIC has been lost then the person who lost it will be required to fill out and sign a Statutory Declaration that they have lost it and return it to you before the visit can be closed and the person can apply for another VIC. If the VIC has been stolen then a police report must be filed and you must be provided with a copy of the police report or the police report number before the visit can be closed and the person can apply for another VIC.</p>
				</div> <!-- help-desk-content -->
			</li>
            
            <li>
				<a class="help-desk-trigger" href="#0">What is Saved Applicants?</a>
				<div class="help-desk-content">
					<p>
This is a list of applications that have gotten to the first step of the Add New Visitor process and have been saved to continue in the future. Also contained in this list is the individuals that have been added to the system through the Bulk Upload process. To continue with one of these, click on the 'Continue Application' link and you will be taken to step 2 of the application process.</p>
				</div> <!-- help-desk-content -->
			</li>
            
            
		</ul>
     
    </div> 
</section> 

<style>

.help-desk *::after,.help-desk *::before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.help-desk *::after,.help-desk *::before {
  content: '';
}
.help-desk a:hover, .help-desk a:focus
{
	text-decoration:none;
	}
.help-desk:after {
  content: "";
  display: table;
  clear: both;
}
.help-desk-categories a::before, .help-desk-categories a::after {
  /* plus icon on the right */
  position: absolute;
  top: 50%;
  right: 16px;
  display: inline-block;
  height: 1px;
  width: 10px;
  background-color: #7f868e;
}
.help-desk-categories a::after {
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.help-desk-categories li:last-child a {
  border-bottom: none;
}
.no-js .help-desk-items {
  position: static;
  height: auto;
  width: 100%;
  -webkit-transform: translateX(0);
  -moz-transform: translateX(0);
  -ms-transform: translateX(0);
  -o-transform: translateX(0);
  transform: translateX(0);
      padding-left: 0;

}

  .help-desk-items {
    position: static;
    height: auto;
    width: 100%;
    float: none;
    overflow: visible;
    -webkit-transform: translateZ(0) translateX(0);
    -moz-transform: translateZ(0) translateX(0);
    -ms-transform: translateZ(0) translateX(0);
    -o-transform: translateZ(0) translateX(0);
    transform: translateZ(0) translateX(0);
    padding: 0;
    background: transparent;
  }

 

.cd-close-panel {
  position: fixed;
  top: 5px;
  right: -100%;
  display: block;
  height: 40px;
  width: 40px;
  overflow: hidden;
  text-indent: 100%;
  white-space: nowrap;
  z-index: 2;
  /* Force Hardware Acceleration in WebKit */
  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -webkit-transition: right 0.4s;
  -moz-transition: right 0.4s;
  transition: right 0.4s;
}
.cd-close-panel::before, .cd-close-panel::after {
  /* close icon in CSS */
  position: absolute;
  top: 16px;
  left: 12px;
  display: inline-block;
  height: 3px;
  width: 18px;
  background: ##0088cc;
}
.cd-close-panel::before {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}
.cd-close-panel::after {
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
}
.cd-close-panel.move-left {
  right: 2%;
}
@media only screen and (min-width: 768px) {
  .cd-close-panel {
    display: none;
  }
}

.help-desk-group {
  /* hide group not selected */
    display: block;
  list-style-type:none;
  margin:0;
}
.help-desk-group.selected {
  display: block;
}
.help-desk-group .help-desk-title {
  background: transparent;
  box-shadow: none;
  margin: 1em 0;
}
.no-touch .help-desk-group .help-desk-title:hover {
  box-shadow: none;
}
.help-desk-group .help-desk-title h2 {
  text-transform: uppercase;
  font-size: 12px;
    font-size: 1.0rem;
  padding-top: 16px;
  font-weight: 700;
  color: #bbbbc7;
}
.no-js .help-desk-group {
  display: block;
  
}

  .help-desk-group > li {
    background: #F5F5F5;
    margin-bottom: 6px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    -webkit-transition: box-shadow 0.2s;
    -moz-transition: box-shadow 0.2s;
    transition: box-shadow 0.2s;
	padding-left: 20px;
	line-height:1;
  }
  .no-touch .help-desk-group > li:hover {
    box-shadow: 0 1px 10px rgba(108, 125, 142, 0.3);
  }
  .help-desk-group .help-desk-title {
    margin: 2em 0 1em;
  }
  .help-desk-group:first-child .help-desk-title {
    margin-top: 0;
  }


.help-desk-trigger {
  position: relative;
  display: block;
  margin: 1.6em 0 .4em;
  line-height: 1.2;
  font-size: 24px;
  font-size: 1.1rem;
  font-weight: 300;
  margin: 0;
  padding: 10px 32px 10px 0px;
}
@media only screen and (min-width: 768px) {
  .help-desk-trigger::before, .help-desk-trigger::after {
    /* arrow icon on the right */
    position: absolute;
    right: 28px;
    top: 50%;
    height: 2px;
    width: 8px;
    background: #0088cc;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    transition-property: transform;
    -webkit-transition-duration: 0.2s;
    -moz-transition-duration: 0.2s;
    transition-duration: 0.2s;
  }
  .help-desk-trigger::before {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg);
    right: 32px;
  }
  .help-desk-trigger::after {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }
  .content-visible .help-desk-trigger::before {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }
  .content-visible .help-desk-trigger::after {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg);
  }


.help-desk-content p {
  font-size: 14px;
  font-size: 0.875rem;
  line-height: 1.6;
  color: #6c7d8e;
  padding-bottom:15px;
  margin-bottom:0;
}
  .help-desk-content {
    display: none;
	
	
  }



</style>

</div>