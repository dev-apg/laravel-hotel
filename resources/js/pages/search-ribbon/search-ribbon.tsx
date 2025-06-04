import { SearchData } from '@/types';
import { useForm } from '@inertiajs/react';
import { format, isAfter, isSameDay, startOfDay } from 'date-fns';
import { DateRange } from 'react-day-picker';
import DatePicker from './date-picker';
import Rooms from './rooms';
import SelectHotel from './select-hotel';

interface SearchRibbonProps {
    searchData: SearchData;
}

interface SearchForm {
    selectedHotel: string | number | undefined;
    selectedDate: DateRange | undefined;
}

export default function SearchRibbon({ searchData }: SearchRibbonProps) {
    const { hotels, selectedHotelID, checkin, checkout } = searchData;
    const { data, setData, post, get, processing, errors, reset } = useForm<Required<SearchForm>>({
        selectedDate: {
            from: checkin ? new Date(checkin) : undefined,
            to: checkout ? new Date(checkout) : undefined,
        },
        selectedHotel: selectedHotelID ? selectedHotelID : '',
    });

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
            <SelectHotel hotels={searchData.hotels}></SelectHotel>
            <DatePicker className={''} date={data.selectedDate} setDate={handleSetDate} />
            <Rooms />
        </div>
    );
}
