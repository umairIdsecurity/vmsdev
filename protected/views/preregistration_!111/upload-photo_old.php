<?php
$session = new CHttpSession;
//$visitor = Registration::model()->findByPk($session['visitor_id']);
$visitor = Registration::model()->findByPk(Yii::app()->user->id);
$preImg = '';
if(!empty($visitor->photo) && !is_null($visitor->photo)){
    $photoModel=Photo::model()->findByPk($visitor->photo);
    if(!empty($photoModel->db_image))
    {
        $preImg = "data:image;base64," . $photoModel->db_image;
    }
    else
    {
        $preImg = Yii::app()->theme->baseUrl.'/images/user.png';
    }
}
else{
    $preImg = Yii::app()->theme->baseUrl.'/images/user.png';
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css">
<style>
.custom-file-button2{
  background: url("<?php echo Yii::app()->theme->baseUrl; ?>/images/upload1.png") top center no-repeat;
  background-size: 90px auto;
  width: 20%;
}
.custom-file-button2 input {
  opacity: 0;
}
.form-upload-img .custom-file-button2 input {
  height: 80px;
  width: 106%;
}
</style>
<div class="page-content">

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <span class="text-size">Please upload a photo head and shoulders picture with no glasses or hat, on a white background. A Photo is not required if your visit is less than 24 hours.</span>
    
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id' => 'upload-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' =>
            array(
                'enctype' => 'multipart/form-data',
				'onsubmit'=>"return false;",
                'class' => 'form-upload-img',
            ),

    )); ?>


    <div class="row">
        <div class="col-sm-4">&nbsp;</div>
        <div class="col-sm-4">
            <div class="image-user">
                <img id="photo" width="220" name="UploadForm[cameraImage]" height="253">
				<video id="video"></video>
				<canvas id="canvas" style="display:none;"></canvas>
				<div id="buttoncontent">

				</div>
	
                <div class="custom-file-button" id='webcam' style="width: 220px">
                    <input id="startbutton" type="button">
					<a href="#" style="display:inherit;" id='retake' class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-repeat"></span> Retake</a>
                </div>
				
                    
              
                <h4 class="subheading-size" id='txt' style="text-align:center;width: 220px">OR<br>Upload</h4>
				<br><br>
				<img id="photo1" width="220" name="UploadForm[cameraImage]" height="253">
			  <div class="custom-file-button2" style="width: 220px">
                    <?php echo $form->fileField($model,'image'); ?>
					<a href="#" style="display:inherit;" id='refresh' class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-refresh"></span> Restart</a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">&nbsp;</div>
    </div>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/addAsic")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php
                        echo CHtml::tag('button', array(
							'onclick'=>'js:imageupload();',
                            'type'=>'submit',
                            'class' => 'btn btn-primary btn-next',
                        ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                    ?>
                </div>
            </div>
        </div>
    </div>  


    <?php $this->endWidget(); ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>
<script type="text/javascript">
var image;

$('#refresh').hide();

 function readURL(input) {

        if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
            $('#photo1').attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]);
         }
     }
 $('#UploadForm_image').bind('change', function() {

        var f = this.files[0]

        if (f.size > 2000000 || f.fileSize > 2000000)
        {
            alert("Allowed file size exceeded. (Max. 2 MB)")

            this.value = null;
        }
        else{
				video.style.display = "none";
				canvas.style.display = "none";
				    photo.setAttribute('src', '');
					$('#photo').hide();
					$('#webcam').hide();
					$('#txt').hide();
					$('#refresh').show();
            readURL(this);
        }

    });
	$('#refresh').on('click',function(){
		$('#refresh').hide();
		location.reload();
		
	});
	  function imageupload()
  {
	  var webtake=$('#photo').attr('src');
	  var upimg=$('#photo1').attr('src');
	  
	  
	 
	  if((typeof webtake!=='undefined') && webtake!='')
	  {
		 
		$.ajax({
			type: "POST",
			url: '<?php echo Yii::app()->createUrl('preregistration/uploadPhoto'); ?>',
			data:{ 
						imgBase64: image
				},
			 success: function(data) {
				window.location.href = "<?php echo Yii::app()->createUrl('preregistration/visitDetails'); ?>";
			 }
			});
	  }
	  else if(upimg!='' && (typeof upimg!=='undefined'))
	  {
		  var form = $('#upload-form');
		 var formData = new FormData();
		  $.each($('input[type=file]',form )[0].files, function (i, file) {
                       formData.append("name", file);
                   });
		  
		$.ajax({
			type: "POST",
			url: '<?php echo Yii::app()->createUrl('preregistration/uploadPhoto'); ?>',
			data: formData,
			processData: false,
			contentType: false,
			enctype: 'multipart/form-data',
			 success: function(data) {
				window.location.href = "<?php echo Yii::app()->createUrl('preregistration/visitDetails'); ?>";
			   // alert(data);
			 }
			});
	  }
	  else
		{
			 $.alert({
				title: 'No Information Added',
				content: 'Please either upload an image or take an image from your webcam',
					});
		}
  }
 
(function() {
	
	$('#retake').hide();
  var streaming = false,
    video = document.querySelector('#video'),
    canvas = document.querySelector('#canvas'),
    buttoncontent = document.querySelector('#buttoncontent'),
    //photo = document.querySelector('#photo'),
    startbutton = document.querySelector('#startbutton'),
    width = 220,
    height = 253;

  navigator.getMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

  navigator.getMedia({
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev) {
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth / width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
	
  }, false);
  var track;

  function takepicture() {
    video.style.display = "none";
    canvas.style.display = "none";
    //startbutton.innerText= "RETAKE";
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/jpg');
	image = canvas.toDataURL("image/jpg").replace("image/jpg", "image/octet-stream");
	//alert(image);
	//window.location.href=image;
    photo.setAttribute('src', image);
	$('#photo').show();
	
	$('#retake').show();
	//$('#retake').style.display='inherit';
	track = video.mozSrcObject.getTracks()[0];  // if only one media track
     //track.stop();

  }
  

  startbutton.addEventListener('click', function(ev) {
		
			takepicture();
			
    ev.preventDefault();
  }, false);
 retake.addEventListener('click', function(ev) {
		
		$('#photo').hide();

		 video.style.display = "block";
		 $('#retake').hide();
		
		
    ev.preventDefault();
  }, false);
})();
  
 
</script>