<div class="votingContainer">
	<div class="imageContainer imgLeft pull-left leftImgShadow">
		<img src="http://lorempixel.com/268/295" height="100%" width="100%" />
	</div>
	<div class="imageContainer imgRight pull-right rightImgShadow">
		<img src="http://lorempixel.com/268/295" height="100%" width="100%" />
	</div>
	<div class="bannerContainer">
		<div class="leftBanner photoBanner">
			<img src="<?php echo base_url('/img/leftFlag.png'); ?>" height="100%" width="100%"/>
			<div class="bannerText bannerTextLeft">Chester the great</div>
		</div>
		
		<div class="rightBanner photoBanner">
			<img src="<?php echo base_url('/img/rightFlag.png'); ?>" height="100%" width="100%"/>
			<div class="bannerText bannerTextRight">Morris</div>
		</div>
	</div>
	<div class="vsFlag">
		<img src="<?php echo base_url('/img/vsFlag.png'); ?>" height="100%" width="100%"/>
	</div>
	<div class="clearFloat"></div>
	<div class="horzSpacer"></div>
</div>

<div class="graphAndAddContainer">
	<div class="segment currentResultsSegment" id="currentResultsSegment">
		<div class="segmentTitle currentResultsTitle">
			<img src="<?php echo base_url('/img/currentResults.png'); ?>" height="100%" width="100%" />
		</div>
		<div class="well segmentContentContainer">
			
		</div>
	</div>
	<div class="segment whatsThisSegment" id="whatsThisSegment">
		<div class="segmentTitle whatsThisTitle" id="whatsThisTitle">
			<img src="<?php echo base_url('/img/whatsThis.png'); ?>" height="100%" width="100%" />
		</div>
		<div class="well segmentContentContainer">
			<div class="whatsThisInfoContainer">
				<div class="whatsThisInfoWrapper">
					<div class="whatsThisInfo">Hotcatz pits one feline against another in furry vs furry battle. Does YOUR cat have what it takes to be a Hotcatz superstar?</div>
					<div class="whatsThisInfoButton"><div><span class="glyphicon glyphicon-plus"></span> New Competitor </div><div>(upload your cat)</div></div>
				</div>
			</div>
			<div class="uploaderContainer">
				<div class="uploadImageContainer">
					<img id="uploadedImage" src="<?php echo base_url('/img/uploadImagePlaceHolder.png'); ?>" height="100%" width="100%" />
				</div>
				<div class="uploadFormContainer">
					<form method="post" id="catUploadForm" class="form-horizontal" action="<?php echo site_url('api/add');?>">
						<input type="text" class="uploadInput" name="catname" id="catname" placeholder="Your cat's name" required/>
						<input type="file" class="uploadSelectFile" name="catpic" id="catpic" required/>
						<input type="submit" value="Upload!" />
					</form>
					<div class="" id="uploadResult"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearFloat"></div>
</div>

<div class="horzRule"></div>

<div class="leaderBoardContainer">
	<div class="segment leaderBoardSegment">
		<div class="segmentTitle leaderBoardTitle">
			<img src="<?php echo base_url('/img/leaderBoard.png'); ?>" height="100%" width="100%" />
		</div>
		<div class="well segmentContentContainer"></div>
	</div>
</div>

<script language="javascript">
	var segmentInView =false;
	var ANIMATION_DURATION=500;
	var whatsThisSegment_init_left;
	var requestNumber = 0;
	$(document).ready(function(){
		var whatsThisSegment = $("#whatsThisSegment");
		$('#whatsThisTitle, .whatsThisInfoButton').on('click', function(){
			if(segmentInView === true){
				//animate back
				whatsThisSegment.animate({
					left:whatsThisSegment_init_left
				},ANIMATION_DURATION,function(){
					segmentInView = false;
				});
			}
			else{
				//animate into view
				whatsThisSegment_init_left = whatsThisSegment.css("left");
				console.log(whatsThisSegment_init_left);
				whatsThisSegment.animate({
					left:"0%"
				},ANIMATION_DURATION,function(){
					segmentInView = true;
				});
			}
		});
		
		$('#catUploadForm').on('submit',function(e){
			e.preventDefault();
			var formData =  new FormData($(this)[0]);;
			
			$.ajax({
				url: "<?php echo site_url('/api/add');?>",
				type: "POST",
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false
			}).done(function(returnData){
				if(returnData.error !==""){
					$('#uploadResult').html(returnData.error).addClass("text-danger").removeClass('text-success');
				}
				else{
					$('#uploadedImage').attr("src",returnData.data.newUpload.imageLink);
					$('#uploadResult').html("<b>"+returnData.data.newUpload.catName+"</b> has been enlisted!").addClass('text-success').removeClass('text-danger');
				}
			});
			
		});
		
	});
</script>

<?php
/* End of file home_page.php */
/* Location:  ./application/views/home_page.php*/