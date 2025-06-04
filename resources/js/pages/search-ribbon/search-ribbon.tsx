import { Button } from '@/components/ui/button';
import { BookingFormData, RoomAction, RoomData, SearchRibbonProps } from '@/types';
import { useForm } from '@inertiajs/react';
import { format, isAfter, isSameDay, startOfDay } from 'date-fns';
import { useEffect, useReducer } from 'react';
import { DateRange } from 'react-day-picker';
import DatePicker from './date-picker';
import Rooms from './rooms';
import { newRoomData, roomsReducer } from './search-ribbon-functions';
import SelectHotel from './select-hotel';

function createOccupancyString(rooms: RoomData[], param: keyof RoomData): string {
    return rooms.map((room) => room[param].toString()).join(',');
}

export default function SearchRibbon({
    hotels,
    selected = { hotel: null, checkin: null, checkout: null, adults: null, children: null },
}: SearchRibbonProps) {
    const [rooms, dispatchRooms] = useReducer(roomsReducer, [newRoomData(false)]) as [RoomData[], React.Dispatch<RoomAction>];

    function handleReset() {
        dispatchRooms({ type: 'reset' });
        reset();
    }
    const { data, setData, post, get, processing, errors, reset } = useForm<Required<BookingFormData>>({
        selectedDate: {
            from: selected.checkin ? new Date(selected.checkin) : undefined,
            to: selected.checkout ? new Date(selected.checkout) : undefined,
        },
        hotel: selected.hotel ? selected.hotel : '',
        adults: selected.adults ? selected.adults : createOccupancyString(rooms, 'adults'),
        children: selected.children ? selected.children : createOccupancyString(rooms, 'children'),
    });

    useEffect(() => {
        data.adults = createOccupancyString(rooms, 'adults');
        data.children = createOccupancyString(rooms, 'children');
        return () => {};
    }, [rooms]);

    function handleSetDate(newDateRange: DateRange | undefined) {
        if (!newDateRange || !newDateRange.from) {
            setData('selectedDate', newDateRange);
            return;
        }

        if (newDateRange?.to && format(newDateRange.from, 'yyyy-MM-dd') == format(newDateRange.to, 'yyyy-MM-dd')) {
            // prevent check in and check out being the same day
            return;
        }

        const ukFormatter = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Europe/London',
            hour: 'numeric',
            hour12: false,
        });

        const ukHour = parseInt(ukFormatter.format(new Date()), 10);
        const isAfter1PM = ukHour >= 13;

        const ukDate = new Date(new Date().toLocaleString('en-US', { timeZone: 'Europe/London' }));
        const isFromToday = isSameDay(newDateRange.from, ukDate);

        const isFromBeforeToday = isAfter(startOfDay(ukDate), newDateRange.from);

        if (isFromBeforeToday) {
            // prevent booking in past
            return;
        }

        if (isFromToday && isAfter1PM) {
            // prevent booking on same day after cut off time
            return;
        }

        setData('selectedDate', newDateRange);
    }

    return (
        <div id="booking-ribbon">
            <SelectHotel hotels={hotels} data={data} setData={setData}></SelectHotel>
            <DatePicker className={''} date={data.selectedDate} setDate={handleSetDate} />
            <Rooms rooms={rooms} dispatchRooms={dispatchRooms} />
            <Button size={'sm'} onClick={() => console.log(data)}>
                Search
            </Button>
            <Button size={'sm'} onClick={() => handleReset()}>
                reset
            </Button>
        </div>
    );
}
