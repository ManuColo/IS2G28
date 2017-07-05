<script type="text/javascript">
$(document).ready(function(){
	$('#btnDespost').confirmation({
			btnOkLabel:'Si',
			btnCancelLabel:'No',
			title:'Estás seguro?',
			container:'body',
			btnOkClass:'btn btn-sm btn-danger btn-xs',
			btnCancelClass:'btn btn-sm btn-success btn-xs',
			onConfirm:
				function(event,element){
					location.href = '../postulations/myPostulations.php?'+window.location.search.substr(1);
				}
		})
});
</script> 
<?php
if (!isset($_SESSION)) {
	session_start();
}
if ($_SESSION['logged']) { ?>
	<a role="button" id="btnDespost" class="btn btn-danger btn-xs pull-right" data-toggle="modal" href="#ventanaCP"> 
   		<strong>Despostularme</strong> 
	</a>
	<?php 
	$post=$postulation->getId();
	$delPos = $entityManager->getRepository('Postulation')->findBy(array('id'=>$post))[0];
	$entityManager->remove($delPos);
	$entityManager->flush();
	addMessage('warning','Ya no est&aacute;s postulado a la gauchada');
	
} else {
	header("location:../login/login.php?message=accessDenied");
}
?>