<div class="calendar-page">
    <!--<div class="calendar-overlay"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw margin-bottom"></i><span class="sr-only">Loading...</span></div>-->
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-push-4 text-center"><h3 class="margin-top-0 margin-bottom-0"><span class="calendar-month">{{date('F Y',$date)}}</span></h3></div>
        <div class="col-xs-6 col-sm-4 col-sm-pull-4"><a href="{{url('/admin/reservations/list/'.date('Y',$prev_month).'/'.date('m',$prev_month))}}" class="last-month month-nav">Last Month</a></div>
        <div class="col-xs-6 col-sm-4 text-right"><a href="{{url('/admin/reservations/list/'.date('Y',$next_month).'/'.date('m',$next_month))}}" class="next-month month-nav">Next Month</a></div>
    </div>
    <table class="table calendar">
        <thead>
            <tr>
                <th><span class="visible-xs">Sun</span><span class="hidden-xs">Sunday</span></th>
                <th><span class="visible-xs">Mon</span><span class="hidden-xs">Monday</span></th>
                <th><span class="visible-xs">Tues</span><span class="hidden-xs">Tuesday</span></th>
                <th><span class="visible-xs">Wed</span><span class="hidden-xs">Wednesday</span></th>
                <th><span class="visible-xs">Thurs</span><span class="hidden-xs">Thursday</span></th>
                <th><span class="visible-xs">Fri</span><span class="hidden-xs">Friday</span></th>
                <th><span class="visible-xs">Sat</span><span class="hidden-xs">Saturday</span></th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <?php $i = 1 ?>
            @for ($p = 1; $p <= date('w',$first_day_of_the_month); $p++)
                <td class="not-this-month">{{date('t',$prev_month) - (date('w',$first_day_of_the_month) - $p)}}</td>
                <?php $i ++ ?>
            @endfor
            @foreach ($month->dates as $dates)
                <td data-date="{{$dates->date_time}}" data-php_date="{{$dates->php_date}}" class="{{(date('mdY',$dates->php_date) == date('mdY',$current_date))?'today':''}} {{((date('mdY',$dates->php_date) == date('mdY',$date)) && ($active_page != 'home'))?'selected':''}}"><a href="{{url('/admin/reservations/list/'.date('Y/m/d',$dates->php_date))}}">
                    <strong class="day-count">{{$dates->day_count}}</strong>
                    @if(isset($dates->reservations))
                    <span class="reservation-count">{{$dates->reservation_count . ' Reservation' . (($dates->reservation_count != 1)?'s':'')}}</span>
                    <!--@foreach ($dates->reservations as $reservation)
                    @if (isset($reservation->contact_name))
                    <a class="cal-event" data-event_id="{{$reservation->id}}" itemscope itemtype="http://schema.org/Event">
                        <span class="event-title" itemprop="name">{{$reservation->contact_name}}</span>
                    </a>
                    @endif
                    @endforeach-->
                    @endif
                </a>
                </td>
                @if($i % 7 == 0)
                </tr><tr>
                @endif
                <?php $i++; ?>
            @endforeach

            @for ($f = 1; $f <= (6 - date('w', $last_day_of_the_month)); $f++)
                <td class="not-this-month">{{$f}}</td>
                <?php $i ++ ?>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
