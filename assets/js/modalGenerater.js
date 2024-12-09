function createModal(mdlId, mdlClass, mdlTabIndex) { //mdlClass variants "modal-fs"
	function makeModal() {
		$("body").append('<div id="' + mdlId + '" class="modal fade ' + mdlClass + '" data-backdrop="static" tabindex="' + mdlTabIndex + '">' +
			'<div class="modal-dialog">' +
			'<div class="modal-content">' +
			'</div>' +
			'</div>' +
			'</div>');
		$("#abbas").modal('show');
		console.log(mdlId + ',modal created!');
	}
	if ($('#' + mdlId).length){
		console.log(mdlId + ',found exist modal');
		$('#' + mdlId).remove();
		console.log(mdlId + ',remove found modal');
		makeModal();
	} else {
		makeModal();
	}
}