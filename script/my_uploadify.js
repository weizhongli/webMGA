$(document).ready(function() {
    //initiation
    $("#submitbutton").attr("disabled",false);
    $("#examplesubmitbutton").attr("disabled",false);

    //Program table help info 
    $('.tagcmd').parent().colorbox({width:"860px",opacity:0.85,overlayClose:false,maxHeight:"90%",onOpen:function(){},onClosed:function(){}});
    $('#colorbox').addClass('shadow');
    $('.tagcmd').parent().parent().hover(
    function () {
        $(this).addClass('highlighted');
    },
    function () {
        $(this).removeClass('highlighted');
    }
    )

    //Round corners
    if (! $.browser.msie)
    {
    $('#main').corner('bottom');
    $('#topmenu li').corner('top 6px');
    $('#srvmenu li.group').corner('left 4px');
    $('#srvmenu li.program').corner('4px');
    $('#srvmenu a').corner('4px');
    $('#srvmain').corner('6px');
    $('#srvmenu ul.group').corner('bl 6px');
    $('.tagcmd').corner('tl br 4px');
    $('#colorbox').corner();
    }

    //Parameter descriptions
    $('.serverform pre.optdesc').hide();
    $('.serverform #optdescswitch').click(
    function() {
        $(this).next('pre.optdesc').toggle();
        toggleText($(this), 'hide description', 'show description');
    }
    );

    //Server example
    $('#serverexampleswitch').click(
    function() {
        $('#serverform').toggle('slow');
        $('#serverformexample').toggle('slow');
        toggleText($(this), 'Show an example', 'Close example');
        $('#output').hide();
    }
    );

    //Set up AJAX job submission form
    var ajaxJobFormOptions = {
        url: '/webMGA/cgi-bin/NGS-web.cgi',
        target: '#outputinner',
        beforeSubmit: function() {
            $("#output").hide().empty().append('<div id="outputinner"></div>').removeClass("output_err").addClass("output_succ");
            $("#submitbutton").attr("disabled",true);
            $("#loader").show();
        },
        success: function () {
            $("#submitbutton").attr("disabled",false);
            $("#loader").hide();
            if ($("#output").text().substr(0,6) == "Error!") {
                $("#output").removeClass("output_succ").addClass("output_err");
            }
            $("#output").fadeIn("slow");
        }
    };
    $("#server").ajaxForm(ajaxJobFormOptions);

    //Set up AJAX example job submission form
    var ajaxExampleJobFormOptions = {
        url: '/webMGA/cgi-bin/submit_web_example.cgi',
        target: '#outputinner',
        beforeSubmit: function() {
            $("#output").hide().empty().append('<div id="outputinner"></div>').removeClass("output_err").addClass("output_succ");
            $("#examplesubmitbutton").attr("disabled",true);
            $("#loader").show();
        },
        success: function () {
            $("#examplesubmitbutton").attr("disabled",false);
            $("#loader").hide();
            if ($("#output").text().substr(0,6) == "Error!") {
                $("#output").removeClass("output_succ").addClass("output_err");
            }
            $("#output").fadeIn("slow");
        }
    };
    $("#serverexample").ajaxForm(ajaxExampleJobFormOptions);

    //Set up AJAX mail submission form
    var ajaxMailFormOptions = {
        url: '/webMGA/contact/request.php',
        target: '#outputinner',
        beforeSubmit: function() {
            $("#output").hide().empty().append('<div id="outputinner"></div>').removeClass("output_err").addClass("output_succ");
            $("#submitbutton").attr("disabled",true);
            $("#loader").show();
        },
        success: function () {
            $("#submitbutton").attr("disabled",false);
            $("#loader").hide();
            if ($("#output").text().substr(0,10) == "Attention:") {
                $("#output").removeClass("output_succ").addClass("output_err");
            }
            $("#output").fadeIn("slow");
        }
    };
    $("#contactform").ajaxForm(ajaxMailFormOptions);

    //Sidemenu
    $('ul.group').hide();
    $('#srvmenu li.srvcurrent').parent().show().prev().addClass('srvcurrent');
    $('li.group').click( function() {
        $(this).siblings('li.group:not(.srvcurrent)').next('ul.group').slideUp();
        if (! $(this).hasClass('srvcurrent'))
        {
            $(this).next('ul.group').slideToggle();
        }
    }
    )
}
);

function toggleText(element,text1,text2) {
    if (element.text() == text1) {
        element.text(text2);
    }
    else if (element.text() == text2) {
        element.text(text1);
    }
    else {
        element.text('?');
    }
};
