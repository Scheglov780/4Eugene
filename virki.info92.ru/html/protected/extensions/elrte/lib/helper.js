
function setupElrteEditor(id, el_clicked, theme, height)
{
	$(el_clicked).hide();

	var lang = 'ru';
    var dialog;
	var opts = {
		lang         : lang, 
		styleWithCSS : false,
		height       : height,
		toolbar      : theme,
        absoluteURLs : true,
        allowSource : true,
//        resizable : false,
        fmAllow : true,
/*		fmOpen : function(callback) {
			$('<div />').dialogelfinder({
				url: 'admin/filemanager/index',
				lang: lang,
				commandsOptions: {
					getfile: {
						oncomplete: 'destroy'
					}
				},
				getFileCallback: callback
			});
		}
*/
        fmOpen : function(callback) {

            if (!dialog) {
                // create new elFinder
                dialog = $('<div />').dialogelfinder({
                    url : '/admin/fileman/index',
                    lang : 'ru',
                    commandsOptions : {
                        getfile : {
                            onlyURL  : true,
                            // allow to return multiple files info
                            multiple : false,
                            // allow to return filers info
                            folders  : false,
                            // action after callback (""/"close"/"destroy")
                            oncomplete : 'close'
                        }
                    },
                    getFileCallback : callback // передаем callback файловому менеджеру
                })
            } else {
                dialog.dialogelfinder('open')
            }
        }

	};

	//$('#'+id).elrte(opts);
    var editor = new elRTE(document.getElementById(id), opts);
    editor.tabsbar.children('.tab').click();
/* Alexy codemirror for elrte it's working but problems with editor
    var elrteCodeMirror = CodeMirror.fromTextArea(
        document.getElementById(id)
        , {
            //lineNumbers: true,
            mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
            matchBrackets: true
        });
    elrteCodeMirror.setSize(null, '100%');
    elrteCodeMirror.refresh();
*/

	return false;

}
