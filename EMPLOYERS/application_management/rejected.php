<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<div class="fright">

	<?php
	
	echo LinkTile
		 (
			"application_management",
			"approved",
			$M_APPROVED_APPLICATIONS,
			"",
			"green"
		 );
		 
		 
			echo LinkTile
		 (
			"application_management",
			"list",
			$JOBSEEKERS_APPLIED,
			"",
			"blue"
		 );
	
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $M_REJECTED_JOBSEEKERS;?>
</h3>
<br/>
<?php


	if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
	{
		if(sizeof($_REQUEST["CheckList"])>0)
		{
			$website->ms_ia($_REQUEST["CheckList"]);
			$database->SQLDelete("apply","id",$_REQUEST["CheckList"]);
		}
	}
	
		$hideSearchFields = true;
	$strSQLQuery ="
			(SELECT ".
			 $DBprefix."jobseekers.first_name,"
			.$DBprefix."jobseekers.last_name,"
			.$DBprefix."jobseekers.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.date
			FROM
			".$DBprefix."apply,".$DBprefix."jobseekers,".$DBprefix."jobs
			WHERE 
			".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker 
			AND
			".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
			AND
			".$DBprefix."jobs.employer='".$AuthUserName."'
			AND
			".$DBprefix."apply.status = '2')
			UNION 
			(SELECT ".
			 $DBprefix."jobseekers_guests.first_name,"
			.$DBprefix."jobseekers_guests.last_name,"
			.$DBprefix."jobseekers_guests.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.date
			FROM
			".$DBprefix."apply,".$DBprefix."jobseekers_guests,".$DBprefix."jobs
			WHERE 
			".$DBprefix."jobseekers_guests.id=".$DBprefix."apply.guest_id 
			AND
			".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
			AND
			".$DBprefix."jobs.employer='".$AuthUserName."'
			AND 
			guest=1
			AND
			".$DBprefix."apply.status = '2')
	";
	
	$strListFields = 
			 $DBprefix."jobseekers.first_name,"
			.$DBprefix."jobseekers.last_name,"
			.$DBprefix."jobseekers.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.date";

if($database->SQLCount_Query($strSQLQuery)==0)	
{
	?>
	<br>
	<table summary="" border="0" width="100%">
 	<tr>
 		<td>
		
			<i>
			<?php echo $M_NO_REJECTED_CANDIDATED;?>
			</i>
		
		</td>
 	</tr>
 </table>
	
	<?php
}
else
{
	
		RenderTable(
						"apply,".$DBprefix."jobseekers",
						array("JobseekerDetails","first_name","last_name","date","ApproveReject1"),
						array($M_JOBSEEKER,$FIRST_NAME,$LAST_NAME,$DATE_MESSAGE,""),
						"500",
						"WHERE ".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker AND ".$DBprefix."apply.status = '2' ",
						$EFFACER,
						"id2",
						"index.php?category=".$category."&action=".$action,
						false,
						20,
						false,
						-1,
						"",
						$strSQLQuery
					);
}						
	?>
