/**
 * 错误对话框
 * @param  {[type]} msg  [description]
 * @param  {[type]} time [description]
 * @return {[type]}      [description]
 */
function errar_confirm(msg='错误',time=3000) {
	$.confirm({
		title: msg,
		content: false,
		autoClose: 'cancel|'+time,
		confirmButton: false,
		theme: 'black'
	});
}
/**
 * 成功对话框
 * @param  {[type]} msg  [description]
 * @param  {[type]} time [description]
 * @return {[type]}      [description]
 */
function success_confirm(msg='OK',time=3000) {
	$.confirm({
		title: false,
		content: msg,
		autoClose: 'confirm|'+time,
		cancelButton: false,
		theme: 'red'
	});
}
