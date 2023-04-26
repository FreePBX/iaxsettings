$(document).ready(function() {
	$('.sortable').sortable(	{
		update: function(event, ui) {
			//console.log(ui.item.find('input').val(), ui.item.index())
			ui.item.find('input').val(ui.item.index());
		},
	});
	$('#ajaxsubmit').on('click',function(e)
	{
		//validate minregexpire maxregexpire
		if(parseInt($('#minregexpire').val()) > parseInt($('#maxregexpire').val()))
		{
			fpbxToast(_("Minregexpire is Greater than Maxregexpire"),'error', 'error');
			return false;
		}

		$.ajax({
			type: 'POST',
			url: window.FreePBX.ajaxurl + '?module=iaxsettings&command=savesettings',
			data: $('#editIax').serialize(),
			success: function (data) {
				if(data.status === true)
				{
					if (data.needreload === true)
					{
						location.reload();
					}
				}
				else
				{
					if(Array.isArray(data.message))
					{
						data.message.forEach(function(entry)
						{
							fpbxToast(entry,'error', 'error');
						});
					}
				}
			}
		});

	});
});

$(document).ready(function(){

	/* Add a Custom Var / Val textbox */
	$("#iax-custom-add").click(function(){
		addCustomField("","");
	});

	/* Initialize Video Support settings and show/hide */
	if (document.getElementById("videosupport-no").checked) {
		$(".video-codecs").hide();
	}
	$("#videosupport-yes").click(function(){
		$(".video-codecs").show();
	});
	$("#videosupport-no").click(function(){
		$(".video-codecs").hide();
	});

	/* Initialize Jitter Buffer settings and show/hide */
	if (document.getElementById("jitterbuffer-no").checked) {
		$(".jitter-buffer").hide();
	}
	$("#jitterbuffer-yes").click(function(){
		$("#jitterbuffer").removeClass("hidden");
	});
	$("#jitterbuffer-no").click(function(){
		$("#jitterbuffer").addClass("hidden");
	});
});

var theForm = document.editIax;
/* Insert a iax_setting/iax_value pair of text boxes */
function addCustomField(key, val) {
	var idx = getMaxCustomSetting() + 1;
	$("#iax-custom-buttons").prepend(`
		<div class="row" id="iax_custom_row_${idx}">
			<div class="col-md-5">
				<input type="text" id="iax_custom_key_${idx}" name="iax_custom_key_${idx}" class="form-control iax-custom" value="${key}">
			</div>
			<div class="col-md-6">
				<input type="text" id="iax_custom_val_${idx}" name="iax_custom_val_${idx}" class="form-control" value="${val}">
			</div>
			<div class="col-md-1">
				<button type="button" class="btn btn-danger btn-block btn-remove-iax-custom" data-iax_custom="${idx}" title="` + _("Remove Setting") + `"><i class="fa fa-trash" aria-hidden="true"></i></button>
			</div>
		</div>
	`);
}

$(document).ready(function(){
	$("#iax-custom-buttons").on("click", ".btn-remove-iax-custom", function() {
		var idx = $(this).data("iax_custom");
		var selector = `#iax_custom_row_${idx}`;
		$(selector).remove();
	});
});

function getMaxCustomSetting()
{
	var divs = $("#iax-custom-buttons [id^='iax_custom_row_']");
	var maxId = Math.max.apply(null, divs.map(function() {
		return parseInt(this.id.match(/\d+/)[0]) || 0;
	}).get());
	maxId = (isNaN(maxId) || maxId === -Infinity) ? -1 : maxId;
	return maxId;
}