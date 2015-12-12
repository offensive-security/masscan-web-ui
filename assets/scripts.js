var delayTimer;
$('#myModal').on('show', function () {
    $(this).find('.modal-body').css({width:'auto',
                               height:'auto', 
                              'max-height':'100%'});
    
    
});

jQuery(document).ready(function () {
    jQuery('.collapse')
        .on('shown.bs.collapse', function() {
            jQuery('#search-params').html('');
            jQuery(this)
                .parent()
                .find(".glyphicon-plus")
                .removeClass("glyphicon-plus")
                .addClass("glyphicon-minus");

        })
        .on('hidden.bs.collapse', function() {
            jQuery(this)
                .parent()
                .find(".glyphicon-minus")
                .removeClass("glyphicon-minus")
                .addClass("glyphicon-plus");

            var text = new Array;
            if (jQuery('#ipAddress').val().length > 0){
                text[text.length] = "IP: <strong>" + jQuery('#ipAddress').val() + "</strong>";
            }
            if (jQuery('#portN').val().length > 0){
                text[text.length] = "Port: <strong>" + jQuery('#portN').val() + "</strong>";
            }
            if (jQuery('#serviceState').val().length > 0){
                text[text.length] = "Service state: <strong>" + jQuery('#serviceState').val() + "</strong>";
            }
            if (jQuery('#pProtocol').val().length > 0){
                text[text.length] = "Protocol: <strong>" + jQuery('#pProtocol').val() + "</strong>";
            }
            if (jQuery('#pService').val().length > 0){
                text[text.length] = "Service: <strong>" + jQuery('#pService').val() + "</strong>";
            }
            if (jQuery('#pBanner').val().length > 0){
                text[text.length]= "Banner/Title: <strong>" + jQuery('#pBanner').val() + "</strong>";
            }
            if (text.length > 0) {
                var html = '<p class="text-muted">';
                for (var i =0; i < text.length; i++)
                {
                    html += text[i];
                    if (i+1 < text.length) {
                         html += " | ";
                    }
                }
                html += "</p>";
                jQuery('#search-params').html(html);
            }
        });
});

function submitSearchForm()
{
    var data = jQuery('#form').serialize();
    var data = data + '&form=1';
    var ajax_options = {
        beforeSend:function () {
            jQuery('#ajax-loader-form').css('display', 'block');
        },
        complete:function () {
            jQuery('#ajax-loader-form').css('display', 'none');
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert('There was an error durring request. Please try again later!');
        },
        success:function (response, textStatus) {
            jQuery('#ajax-search-container').html(response);
            jQuery('a#export-link').attr('onclick','').unbind('click');
            jQuery('a#export-link').click(function(){
                exportResultsToXML(data);
            });
        },
        timeout:'100000',
        type:'get',
        dataType:'html',
        data:data,
        url:'/filter.php'
    };
    $.ajax(ajax_options);
    return false;
}
function showIpHistory(ip, ipa)
{
	jQuery('#myModalLabel').text('Scan history for IP '+ ip);
    var ajax_options = {
            beforeSend:function () {
                
            },
            complete:function () {
                
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert('There was an error durring request. Please try again later!');
            },
            success:function (response, textStatus) {
            	$('#myModal').modal('show');           	
            	jQuery('.modal-body').html(response);
            },
            timeout:'100000',
            type:'get',
            dataType:'html',
            data:'ip='+ipa,
            url:'/ajax.php'
        };
    $.ajax(ajax_options);
    return false;
}


function exportResultsToXML(data)
{
    var url='/export.php?'+ data;
	var _iframe_dl = $('<iframe />')
	       .attr('src', url)
	       .hide()
	       .appendTo('body');
	return false;
}

function searchDataText(data)
{ 
	clearTimeout(delayTimer);
    delayTimer = setTimeout(function() {
    	searchData(data);
    }, 1000);
}

function searchData(data, throbber)
{
    throbber = typeof throbber !== 'undefined' ? throbber : 'ajax-loader';
    var ajax_options = {
            beforeSend:function () {
                jQuery('#' + throbber).css('display', 'block');
            },
            complete:function () {
                jQuery('#'+ throbber).css('display', 'none');
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert('There was an error durring request. Please try again later!');
            },
            success:function (response, textStatus) {
                jQuery('#ajax-list-container').html(response);
                jQuery('a#export-link').attr('onclick','').unbind('click');
                jQuery('a#export-link').click(function(){
                        exportResultsToXML(data);
                    });
            },
            timeout:'100000',
            type:'get',
            dataType:'html',
            data:data,
            url:'/filter.php'
        };
    $.ajax(ajax_options);
    return false;
}

function showImportHelp()
{
    jQuery('#myModalLabel').text('How to scan and import data?');
    var ajax_options = {
            beforeSend:function () {

            },
            complete:function () {

            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert('There was an error during request. Please try again!');
            },
            success:function (response, textStatus) {
            	$('#myModal').modal('show');
            	jQuery('.modal-body').html(response);
            },
            timeout:'100000',
            type:'get',
            dataType:'html',
            data:'',
            url:'/includes/html/import-help.html'
        };
    $.ajax(ajax_options);
    return false;
}