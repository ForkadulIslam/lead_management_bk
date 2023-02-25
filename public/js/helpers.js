function hexToRgb(hexCode) {
    var patt = /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})$/;
    var matches = patt.exec(hexCode);
    var rgb = "rgb(" + parseInt(matches[1], 16) + "," + parseInt(matches[2], 16) + "," + parseInt(matches[3], 16) + ")";
    return rgb;
}

function hexToRgba(hexCode, opacity) {
    var patt = /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})$/;
    var matches = patt.exec(hexCode);
    var rgb = "rgba(" + parseInt(matches[1], 16) + "," + parseInt(matches[2], 16) + "," + parseInt(matches[3], 16) + "," + opacity + ")";
    return rgb;
}
var delete_with_swal = function(url,_token,remove_section){
    swal({
            title: "Are You Sure ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                $.ajax({
                    type:"DELETE",
                    url : url,
                    data:{_token:_token},
                    success : function(r){
                        if(remove_section){
                            remove_section.remove();
                        }
                        swal({
                            title:"Removed",
                            timer:700,
                            type:"success"
                        })
                    }

                });
            }else{
                swal({
                    title: "Not Removed!!",
                    timer: 700,
                    type: "info"
                });
            }
        }
    );
    return false;
};

var is_confirm = function(callback){
    swal({
            title: "Are You Sure ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                return callback();
            }else{
                swal_close('Not deleted');
            }
        }
    );
    //return false;
};
var swal_close = function(message){
    swal({
        title:message,
        timer:1000,
        type:"success"
    })
}
var toast = function(msg){
    var x = document.getElementById("snackbar");
    if(msg){
        x.innerHTML = msg;
    }
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
};