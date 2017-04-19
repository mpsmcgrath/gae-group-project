

$(function(){               
                $('#testAPI').click(function(e){
                    console.log('TestAPI Function is working');
                    
                    $.ajax({
                        type: 'POST',
                        data: JSON.stringify(storedEvents),
                        contentType: 'application/json',
                        url: 'http://localhost:8080/api/availability',                      
                        success: function(data) {
                            //console.log('success');
                            //console.log(JSON.stringify(storedEvents));
                        }
                    });
                });             
            });


 ////////////////////////////////////////////////////////
                      function saveEvents(){
            for (i=0; i<objectCount;i++) {
             storedEvents.push( {"title":globalEvents[i].title,"dow":globalEvents[i]._start._d.getDay(),"start":globalEvents[i]._start._d, "end":globalEvents[i]._end._d} );
         }

                      //console.log('saveEvents() function triggered, it contains: ' + storedEvents);

            }
             
         var globalEvents;
         var storedEvents = []; 
         var title;
         var eventData;
         var objectCount;
   ////////////////////////////////////////////////////

    $(document).ready(function() {

   
        $('#calendar').fullCalendar({
            defaultView: 'agendaWeek',
            eventLimit: false,
            allDaySlot: false,
//             events: [{
//     title:"My repeating event",
//     start: '10:00', // a start time (10am in this example)
//     end: '14:00', // an end time (6pm in this example)
//     dow: [ 1, 4 ] // Repeat monday and thursday
// }],
            columnFormat: 'ddd',
            timezone: false,
            selectOverlap: false,
            eventOverlap: false,
            selectable: true,
            header : {
                left : '',
                center: '',
                right : ''
                    },
            eventClick: function(calEvent, jsEvent, view)
                  {
                  $('#calendar').fullCalendar('removeEvents', calEvent._id);
                  },
            select: function (start, end, jsEvent, view) 
                {
                var diffmin = (new Date(end).getTime()/1000 - new Date(start).getTime()/1000)/60;
                title = diffmin+' min';
    //http:// some users click 1 slot, then the following, so we have 2 events each 30 min instead of 60 min
    //http:// merge both events into one
    var eventmerge = false;
    if (allevents == null){
        var allevents = new Array();
        allevents = $('#calendar').fullCalendar('clientEvents');
        }
    
    

    $.each(allevents, function( index, eventitem )
    {
        if(eventitem!==null && typeof eventitem != 'undefined')
        {
            // if start time of new event (2nd slot) is end time of existing event (1st slot)
            if( moment(start).format('YYYY-MM-DD HH:mm') == moment(eventitem.end).format('YYYY-MM-DD HH:mm') )
            {
                eventmerge = true;
                // existing event gets end data of new merging event
                eventitem.end = end;
            }
            // if end time of new event (1st slot) is start time of existing event (2nd slot)
            else if( moment(end).format('YYYY-MM-DD HH:mm') == moment(eventitem.start).format('YYYY-MM-DD HH:mm') )
            {
                eventmerge = true;
                // existing event gets start data of new merging event
                eventitem.start = start;
            }
 
            if(eventmerge)
            {
                // recalculate
                var diffmin = (new Date(eventitem.end).getTime()/1000 - new Date(eventitem.start).getTime()/1000)/60;
                eventitem.title = '';

                // copy to eventData
                eventData = eventitem;

                // find event object in calendar
                var eventsarr = $('#calendar').fullCalendar('clientEvents');
                $.each(eventsarr, function(key, eventobj) { 
                    if(eventobj._id == eventitem.id) {
                        console.log('merging events');
                        eventobj.start = eventitem.start;
                        eventobj.end = eventitem.end;
                        eventobj.title = eventitem.title;
                        $('#calendar').fullCalendar('updateEvent', eventobj);
                    }

                });
                
                $('#calendar').fullCalendar('renderEvent', eventData, true);
                return false;
            }
        }
    });


    if(!eventmerge)
    {
        var eventcount;
        eventData = {
            title: '',
            start: start,
            end: end,
            color: '#00AA00',
            editable: true,
            eventDurationEditable: true,
        };
        allevents[eventcount] = eventData;
        eventcount++;

        $('#calendar').fullCalendar('renderEvent', eventData, true);
                }
                 objectCount = Object.keys(allevents).length-1
                 globalEvents = allevents;
                 console.log(allevents);


            },  
        });


    });


