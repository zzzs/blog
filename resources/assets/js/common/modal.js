$('.modal').on('hide.bs.modal', function (event) {
	$(this).find(".modal-title").empty();
	$(this).find(".modal-body").empty();
});
