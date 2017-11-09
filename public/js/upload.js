
var accessid = '';
var accesskey = '';
var host = '';
var policyBase64 = '';
var signature = '';
var callbackbody = '';
var filename = '';
var key = '';
var expire = 0;
var g_object_name = '';
var g_object_name_type = '';
var now = timestamp = Date.parse(new Date()); // 1000;

function get_signature()
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 3000,
        async: false,
        url: '/getvideoupdateauth',
        type: "post",
        data: { 'lessonid': $('#id').val() },
        success: function(data){
            var jsonObj = JSON.parse( data );
            host = jsonObj.host;
            policyBase64 = jsonObj.policy;
            accessid = jsonObj.accessid;
            signature = ojsonObj.signature;
            expire = parseInt(jsonObj.expire);
            callbackbody = jsonObj.callback;
            key = jsonObj.dir;
        }
    });
};

function set_upload_param(up, filename)
{
    g_object_name = key + filename;
    new_multipart_params = {
        'key' : g_object_name,
        'policy': policyBase64,
        'OSSAccessKeyId': accessid,
        'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
        'callback' : callbackbody,
        'signature': signature,
    };

    up.setOption({
        'url': host,
        'multipart_params': new_multipart_params
    });

    up.start();
};

window.onload = new function() {
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'selectfiles',
        //multi_selection: false,
        container: document.getElementById('container'),
        flash_swf_url : "{{ asset('js/Moxie.swf') }}",
        silverlight_xap_url : "{{ asset('js/Moxie.xap') }}",
        url : 'http://oss.aliyuncs.com',

        filters: {
            mime_types : [ //只允许上传图片和zip,rar文件
                { title : "Video files", extensions : "mp4" },
                // { title : "Zip files", extensions : "zip,rar" }
            ],
            max_file_size : '200mb', //最大只能上传10mb的文件
            prevent_duplicates : true //不允许选取重复文件
        },

        init: {
            PostInit: function() {
                document.getElementById('ossfile').innerHTML = '';
                // document.getElementById('postfiles').onclick = function() {
                // set_upload_param(uploader, '', false);
                // return false;
                // };
            },

            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    document.getElementById('ossfile').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')<b></b>'
                        +'<div class="progress"><div class="progress-bar" style="width: 0%"></div></div>'
                        +'</div>';
                });
            },

            BeforeUpload: function(up, file) {
                set_upload_param(up, file.name);
            },

            UploadProgress: function(up, file) {
                var d = document.getElementById(file.id);
                d.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                var prog = d.getElementsByTagName('div')[0];
                var progBar = prog.getElementsByTagName('div')[0]
                progBar.style.width= 2*file.percent+'px';
                progBar.setAttribute('aria-valuenow', file.percent);
            },

            FileUploaded: function(up, file, info) {
                if (info.status == 200)
                {
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = 'upload to oss success, object name:' + get_uploaded_object_name(file.name);
                }
                else
                {
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = info.response;
                }
            },

            Error: function(up, err) {
                if (err.code == -600) {
                    document.getElementById('console').appendChild(document.createTextNode("\n选择的文件太大了"));
                }
                else if (err.code == -601) {
                    document.getElementById('console').appendChild(document.createTextNode("\n选择的文件后缀不对"));
                }
                else if (err.code == -602) {
                    document.getElementById('console').appendChild(document.createTextNode("\n这个文件已经上传过一遍了"));
                }
                else
                {
                    document.getElementById('console').appendChild(document.createTextNode("\nError xml:" + err.response));
                }
            }
        }
    });

    uploader.init();
}
