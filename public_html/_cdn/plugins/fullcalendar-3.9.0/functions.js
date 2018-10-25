
$(function () {
    $('#external-events .fc-event').each(function() {
        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
        });
        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });
})

function DashboardCompromissos() {
    // $.post('_ajax/Agenda.ajax.php', {callback: 'Agenda', callback_action: 'realtime'}, function (data) {
    //     $('#_next').text(data._next);
    //     $('#_today').text(data._today);
    //     $('#_month').text(data._month);
    //     $('#_total').text(data._total);
    //     $("#fullcalendar").fullCalendar( 'refetchEvents');
    // }, 'json');
}


var _customClick = function  (url) {
    ajax({
        params:{},
        text:History.getState().title,
        url:url
    })
}


var  _dayClick = function  (date, jsEvent, view, resourceObj) {
    console.log("_dayClick:", date, jsEvent, view, resourceObj);
    // ajax({
    //     params:{
    //         start:$.fullCalendar.moment(date).format('DD/MM/YYYY H:mm:ss'),
    //         end:$.fullCalendar.moment(date).format('DD/MM/YYYY H:mm:ss')
    //     },
    //     text:"Cadastra Translado",
    //     url:"/admin/oder/create"
    // })
}

var _viewRender = function (view, element) {
    console.log("_viewRender:", view, element);

    // ajax({
    //     params:{},
    //     text:resource.title,
    //     url:resource.parentUrl
    // })
}


var _getDate = function (event) {

    var _data;
    var end;
    var start;
    if(event){
        if(event.end){
            end = event.end.format('DD/MM/YYYY H:mm:ss');
        }
        if(event.start){
            start = event.start.format('DD/MM/YYYY H:mm:ss');
            if(!end){
                end = event.start.format('DD/MM/YYYY H:mm:ss');
            }
        }
    }
    _data = {
        resourceId:event.resourceId,
        start:start,
        end:end
    };
    return _data;
}

function ajax(options) {

    History.pushState(

        options.params,

        options.text,

        options.url
    );
}

var _select = function (startDate, endDate) {
    console.log("_select:", startDate, endDate);
}


var _eventResize = function (event, delta, revertFunc) {
    console.log("_eventResize:", event);
    console.log(_getDate(event));
    // ajax({
    //     params:_getDate(event),
    //     text:event.title,
    //     url:event.resizeUrl
    // })
}

var _eventDrop = function (event) {
    console.log("_eventDrop:", event);
    console.log(_getDate(event));
    // ajax({
    //     params:_getDate(event),
    //     text:event.title,
    //     url:event.dropUrl
    // })
}


var _eventClick = function (calEvent, jsEvent, view) {
    console.log("_eventClick:", calEvent);
    ajax({
        params:{},
        text:calEvent.title,
        url:calEvent.editUrl
    })
}

var _eventMouseover = function (event, jsEvent, view) {
    //console.log("_eventMouseover :", event, jsEvent, view);

}

var _drop =  (date, jsEvent) =>{

    console.log("_drop :",date, jsEvent);

        // let start   = date.format();
        // let end     = date.format();
        // let tour_id = jsEvent.target.dataset.id;

        // History.pushState({
        //     activity_date:start,
        //     end:end,
        //     tour_id:tour_id
        // },jsEvent.target.textContent , jsEvent.target.dataset.create)

    }
