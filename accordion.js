/* 
Simple JQuery menu.

HTML structure to use:

Notes:  Each menu MUST have a class 'menu' set. If the menu doesn't have this, the JS won't make it dynamic
If you want a panel to be expanded at page load, give the containing LI element the classname 'expand'.
Use this to set the right state in your page (generation) code.

Optional extra classnames for the UL element that holds an accordion:

noaccordion : no accordion functionality
collapsible : menu works like an accordion but can be fully collapsed

----------------------

<ul class="menu [optional class] [optional class]">
<li><a href="#">Sub menu heading</a>
<ul class="acitem">
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
</ul>

// This item is open at page load time

<li class="expand"><a href="#">Sub menu heading</a>
<ul class="acitem">
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
</ul>
</ul>
----------------------
Use divs for non list content. You can mix and match.

<ul class="menu [optional class] [optional class]">
<li><a href="#">Sub menu heading</a>
<div class="acitem">
<p>Put your content here</p>
</div>
</li>

<li><a href="#">Sub menu heading 2 </a>
<div class="acitem">
<p>Put your content here</p>
</div>
</li>

<li><a href="#">Sub menu heading</a>
<ul class="acitem">
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
<li><a href="http://site.com/">Link</a></li>
</ul>
</ul>

*/


jQuery.fn.initMenu = function() {  
    return this.each(function(){
        var theMenu = $(this).get(0);
        $('.acitem', this).hide();
        $('li.expand > .acitem', this).show();
        $('li.expand > .acitem', this).prev().addClass('active');
        $('li a', this).click(
            function(e) {
                e.stopImmediatePropagation();
                var theElement = $(this).next();
                var parent = this.parentNode.parentNode;
                if($(parent).hasClass('noaccordion')) {
                    if(theElement[0] === undefined) {
                        window.location.href = this.href;
                    }
                    $(theElement).slideToggle('750', function() {
                        if ($(this).is(':visible')) {
                            $(this).prev().addClass('active');
                        }
                        else {
                            $(this).prev().removeClass('active');
                        }    
                    });
                    return false;
                }
                else {
                    if(theElement.hasClass('acitem') && theElement.is(':visible')) {
                        if($(parent).hasClass('collapsible')) {
                            $('.acitem:visible', parent).first().slideUp('750', 
                            function() {
                                $(this).prev().removeClass('active');
                            }
                        );
                        return false;  
                    }
                    return false;
                }
                if(theElement.hasClass('acitem') && !theElement.is(':visible')) {         
                    $('.acitem:visible', parent).first().slideUp('750', function() {
                        $(this).prev().removeClass('active');
                    });
                    theElement.slideDown('normal', function() {
                        $(this).prev().addClass('active');
                    });
                    return false;
                }
            }
        }
    );
});
};

$(document).ready(function() {$('.accordion').initMenu();});