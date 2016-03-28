$(function(){
    $('.nav-tabs a:first',this.$page).tab('show')
    $('.nav-tabs li:gt(0)',this.$page).each(function(){
        $(this).addClass('disabled');
        $('a',$(this)).attr('data-toggle','');
    });
    
    $('.next-tab').on('click',function(){
        var $panel = $(this).closest('.panel');
        var $tabs = $('.nav-tabs li',$panel);
        var $tab = $('.nav-tabs li.active',$panel);
        var index  = $tabs.index($tab);
        if (index < 0) {
            return; //no hope for you!
        }
        index++;
        var $next_tab = $('a',$tabs.eq(index));
        if (!$next_tab.length) {
            return;
        }
        $next_tab.parents('li').removeClass('disabled');
        $next_tab.attr('data-toggle','tab');
        $next_tab.tab('show');
    });
    $('.previous-tab').on('click',function(){
        var $panel = $(this).closest('.panel');
        var $tabs = $('.nav-tabs li',$panel);
        var $tab = $('.nav-tabs li.active',$panel);
        var index  = $tabs.index($tab);
        if (index < 0) {
            return; //no hope for you!
        }
        index--;
        var $previous_tab = $('a',$tabs.eq(index));
        if (!$previous_tab.length) {
            return;
        }
        $previous_tab.parents('li').removeClass('disabled');
        $previous_tab.data('toggle','tab');
        $previous_tab.tab('show');    });
    
});