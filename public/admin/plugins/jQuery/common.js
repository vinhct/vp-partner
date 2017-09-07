/**
 * Created by B150M on 8/29/2017.
 */
function popupError(id,idtext,text){
    $("#"+id).modal('show');
    $("#"+idtext).html(text);
    $("#"+idtext).css({"color":"red","font-weight": "600"});

}
function popupSucces(id,idtext,text){
    $("#"+id).modal('show');
    $("#"+idtext).html(text);
    $("#"+idtext).css({"color":"green","font-weight": "600"});

}