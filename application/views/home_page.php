<div class="alert displayNone" id="alertBox"></div>
<div class="votingContainer displayNone">
	<div class="imageContainer imgLeft pull-left leftImgShadow">
		<img class="voteImg" id="leftVoteImage" src="" height="100%" width="100%" />
	</div>
	<div class="imageContainer imgRight pull-right rightImgShadow">
		<img class="voteImg" id="rightVoteImage" src="" height="100%" width="100%" />
	</div>
	<div class="bannerContainer">
		<div class="leftBanner photoBanner">
			<img src="<?php echo base_url('/img/leftFlag.png'); ?>" height="100%" width="100%"/>
			<div id="leftVoteName" class="bannerText bannerTextLeft">Chester the great</div>
		</div>
		
		<div class="rightBanner photoBanner">
			<img src="<?php echo base_url('/img/rightFlag.png'); ?>" height="100%" width="100%"/>
			<div id="rightVoteName" class="bannerText bannerTextRight">Morris</div>
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
		<div class="well segmentContentContainer padding_13" id="lbContent">
		</div>
	</div>
</div>

<script language="javascript">
	var segmentInView =false;
	var ANIMATION_DURATION=500;
	var whatsThisSegment_init_left;
	var requestNumber = 0;
	$(document).ready(function(){
		var alertBox = $('#alertBox');
		
		alertBox.success = function (msg){
			$(this).html(msg)
					.addClass('alert-success')
					.removeClass('alert-danger, alert-warning')
					.stop(true,true)
					.show()
					.delay(4000)
					.fadeOut(ANIMATION_DURATION);
		};
		alertBox.error = function(msg){
			$(this).html(msg)
					.addClass('alert-danger')
					.removeClass('alert-success, alert-warning')
					.stop(true,true)
					.show()
					.delay(4000)
					.fadeOut(ANIMATION_DURATION);
		};
		
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
					getLeaderBoardData();
				}
			});
			
		});
		
		$('.imageContainer').on('click',function(){
			var voteImage = $(this).children(".voteImg");
			var data={
				id:voteImage.attr('data-id'),
				voteToken:voteImage.attr('data-votetoken')
			};
			$.ajax({
				url: "<?php echo site_url('/api/vote');?>",
				type: "POST",
				data:data
			}).done(function(returnData){
				if(returnData.error !== ""){
					alertBox.error(returnData.error);
				}
				else{
					//alertBox.success("Voting success.");
					getNewMatchup();
					getLeaderBoardData();
				}
			});
		});
		
		function getNewMatchup(){
			$.ajax({
				url: "<?php echo site_url('/api/getNewMatchup');?>",
				type: "POST"
			}).done(function(returnData){
				if(returnData.error !== ""){
					alertBox.error(returnData.error);
					$('.votingContainer').hide();
				}
				else{
					loadNewMatchupData(returnData.data.matchup);
					$('.votingContainer').show();
				}
			});
		};
		getNewMatchup();
		
		function loadNewMatchupData(data){
			$('#leftVoteImage, #rightVoteImage').attr('data-votetoken',data.voteToken);
			$('#leftVoteImage').attr('src',data[0].cimage);
			$('#leftVoteImage').attr('data-id', data[0].id);
			$('#leftVoteName').html(data[0].name);

			$('#rightVoteImage').attr('src',data[1].cimage);
			$('#rightVoteImage').attr('data-id', data[1].id);
			$('#rightVoteName').html(data[1].name);
		}
		
		function getLeaderBoardData()
		{
			$.ajax({
				url: "<?php echo site_url('/api/getLeaderBoardData');?>",
				type: "POST"
			}).done(function(returnData){
				if(returnData.error !== ""){
					alertBox.error(returnData.error);
				}
				else{
					loadLeaderBoardData(returnData.data.leaderBoard);
				}
			});
		}
		getLeaderBoardData();
		setTimeout(function(){getLeaderBoardData();}, 10000);
		
		function loadLeaderBoardData(data)
		{
			$('#lbContent').html("");
			var i=1;
			//console.log(data);
			data.forEach(function(itemData){
				//console.log(itemData);
				var item = $('#lbItemContainer').clone();
				item.attr('id',itemData.catId);
				item.find('.lbImage').attr('src',itemData.cimage);
				item.find('.lbName').html(itemData.cname);
				item.find('.lbVotes').html(itemData.voteweight+" votes");
				item.find('.lbRank').html("#"+i);
				if(i>0 && i<=3){
					item.addClass('lbFeatured');
					switch(i){
						case 1: item.find('.gold').show();
							break;
						case 2: item.find('.silver').show();
							break;
						case 3: item.find('.bronze').show();
							break;
					}
				}
				if(itemData.isMine){
					item.find('.lbItemIsMineBadge').show();
				}
				$('#lbContent').append(item);
				i++;
			});
			$('#lbContent').append("<div class='clearFloat'></div>");
		}
		
	});
</script>

<div class="displayNone">
	<div class="lbItemContainer" id="lbItemContainer">
		<div class="lbImageContainer">
			<img class="lbImage" src="" width="100%" />
		</div>
		<div class="lbBadgeContainer">
			<div class="lbItemIsMineBadge"></div>
			<div class="ribbon gold"></div>
			<div class="ribbon silver"></div>
			<div class="ribbon bronze"></div>
		</div>
		<div class="lbInfoBoxPopup">
			<div class="lbName">Name</div>
			<div class="lbVotes">1240</div>
			<div class="lbTail"></div>
		</div>
		<div class="lbInfoBoxAttached">
			<div class="lbName">Name</div>
			<div class="lbVotes">1240</div>
		</div>
		<div class="lbRank">#5</div>
	</div>
</div>
<?php
/* End of file home_page.php */
/* Location:  ./application/views/home_page.php*/