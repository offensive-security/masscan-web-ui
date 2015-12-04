var delayTimer;
jQuery(document).ready(function() {
    $( ".datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
});
$('#myModal').on('show', function () {
    $(this).find('.modal-body').css({width:'auto',
                               height:'auto', 
                              'max-height':'100%'});
    
    
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
            jQuery('#content').html(response);
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
function showIpHistory(ip, el, host_id)
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
            data:'host_id='+host_id,
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

function searchData(data)
{ 
    var ajax_options = {
            beforeSend:function () {
                jQuery('#ajax-loader').css('display', 'block');
            },
            complete:function () {
                jQuery('#ajax-loader').css('display', 'none');
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