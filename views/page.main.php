<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

$errordisplay = '';
if(!empty($errors))
{
	$errordisplay .= '<div class = "alert alert-danger">';
	$errordisplay .= implode('<br/>', $errors);
	$errordisplay .= '</div>';
}
?>
<div class="container-fluid">
    <h1><?php echo _('IAX Settings')?></h1>
	<div class = "display full-border">
		<div class="row">
			<div class="col-sm-12">
				<div class="fpbx-container">
                    
                    <?php echo $errordisplay;?>

					<div class="display full-border">
						<?php echo $iaxsettings->showPage('form_options') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
