<script>

    $(document).ready(function() {
        
        $('#calendar').fullCalendar({
            defaultView: 'agendaWeek',
            eventLimit: false,
            allDaySlot: false,
            columnFormat: 'ddd',
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
    var title = diffmin+' min';
    var eventData;
    // some users click 1 slot, then the following, so we have 2 events each 30 min instead of 60 min
    // merge both events into one
    var eventmerge = false;
    if (allevents == null){
        var allevents =new Array();
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
                eventitem.title = diffmin+' min';

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

                // break each loop
                return false;
            }
        }
    });


    if(!eventmerge)
    {
        // console.log('adding event id: '+eventcount);
        var eventcount;
        eventData = {
            // id: eventcount, // identifier
            title: title,
            start: start,
            end: end,
            color: '#00AA00',
            editable: true,
            eventDurationEditable: true,
        };

        // register event in array
        allevents[eventcount] = eventData;
        eventcount++;

        $('#calendar').fullCalendar('renderEvent', eventData, true);
                }
            },  
        });

    });

</script>

      <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
            tinymce.init({ 
                entity_encoding : "raw",
            selector:'textarea' });
    </script>