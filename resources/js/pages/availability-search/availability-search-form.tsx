import { Button } from '@/components/ui/button';
import { BookingFormData, RoomAction, RoomData, SearchRibbonProps } from '@/types';
import { useForm } from '@inertiajs/react';
import { format, isAfter, isSameDay, startOfDay } from 'date-fns';
import { LoaderCircle } from 'lucide-react';
import { FormEvent, useEffect, useReducer, useState } from 'react';
import { DateRange } from 'react-day-picker';
import { newRoomData, roomsReducer } from './availability-search-functions';
import DatePicker from './date-picker';
import Rooms from './rooms';
import SelectHotel from './select-hotel';

function createOccupancyString(rooms: RoomData[], param: keyof RoomData): string {
    return rooms.map((room) => room[param].toString()).join(',');
}

function dataMissing(data: BookingFormData): boolean {
    if (!data.hotel) {
        return true;
    }
    if (!data.from) {
        return true;
    }
    if (!data.to) {
        return true;
    }
    if (!data.rooms) {
        return true;
    }
    if (!data.adults) {
        return true;
    }
    if (!data.children) {
        return true;
    }
    return false;
}

export default function AvailabilitySearchForm({
    hotels,
    selected = { hotel: null, checkin: null, checkout: null, adults: null, children: null },
}: SearchRibbonProps) {
    const [rooms, dispatchRooms] = useReducer(roomsReducer, [newRoomData(false)]) as [RoomData[], React.Dispatch<RoomAction>];

    const [dates, setDates] = useState<{ from: Date | undefined; to?: Date | undefined } | undefined>({
        from: selected.checkin ? new Date(selected.checkin) : undefined,
        to: selected.checkout ? new Date(selected.checkout) : undefined,
    });

    function handleReset() {
        dispatchRooms({ type: 'reset' });
        reset();
    }

    const { data, setData, get, processing, errors, reset } = useForm<Required<BookingFormData>>({
        hotel: selected.hotel ? selected.hotel : '',
        from: dates?.from ? format(dates.from, 'yyyy-MM-dd') : undefined,
        to: dates?.to ? format(dates.to, 'yyyy-MM-dd') : undefined,
        rooms: rooms.length,
        adults: selected.adults ? selected.adults : createOccupancyString(rooms, 'adults'),
        children: selected.children ? selected.children : createOccupancyString(rooms, 'children'),
    });

    useEffect(() => {
        setData('rooms', rooms.length);
        setData('adults', createOccupancyString(rooms, 'adults'));
        setData('children', createOccupancyString(rooms, 'children'));
        return () => {};
    }, [rooms]);

    useEffect(() => {
        setData('from', dates?.from ? format(dates.from, 'yyyy-MM-dd') : undefined);
        setData('to', dates?.to ? format(dates.to, 'yyyy-MM-dd') : undefined);
        return () => {};
    }, [dates]);

    function handleSetDate(newDateRange: DateRange | undefined) {
        if (!newDateRange || !newDateRange.from) {
            setDates(newDateRange);
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

        setDates(newDateRange);
    }

    function submit(e: FormEvent) {
        e.preventDefault();
        get(route('ancillaries', {}), {});
    }

    return (
        <div id="booking-ribbon">
            <form onSubmit={submit} action="" method="get">
                <SelectHotel hotels={hotels} data={data} setData={setData}></SelectHotel>
                <DatePicker className={''} dates={dates} setDate={handleSetDate} />
                <Rooms rooms={rooms} dispatchRooms={dispatchRooms} />
                <Button disabled={dataMissing(data) || processing} type={'submit'} size={'sm'} onClick={() => console.log(data)}>
                    {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                    Search
                </Button>
                <Button type={'reset'} size={'sm'} onClick={() => handleReset()}>
                    Reset
                </Button>
            </form>
        </div>
    );
}
