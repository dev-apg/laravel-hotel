import { Button } from '@/components/ui/button';
import { BookingFormData, SearchRibbonProps } from '@/types';
import { useForm } from '@inertiajs/react';
import { format, isAfter, isSameDay, startOfDay } from 'date-fns';
import { DateRange } from 'react-day-picker';
import DatePicker from './date-picker';
import Rooms from './rooms';
import SelectHotel from './select-hotel';

export default function SearchRibbon({
    hotels,
    selected = { hotel: null, checkin: null, checkout: null, adults: null, children: null },
}: SearchRibbonProps) {
    // const [params, setParams] = useState({
    //     hotelid: selected.hotelid ?? '',
    //     checkin: selected.checkin ?? '',
    //     checkout: selected.checkout ?? '',
    //     adults: selected.adults ?? '',
    //     children: selected.children ?? '',
    // });

    const { data, setData, post, get, processing, errors, reset } = useForm<Required<BookingFormData>>({
        selectedDate: {
            from: selected.checkin ? new Date(selected.checkin) : undefined,
            to: selected.checkout ? new Date(selected.checkout) : undefined,
        },
        hotel: selected.hotel ? selected.hotel : '',
        adults: selected.adults ? selected.adults : '',
        children: selected.children ? selected.children : '',
    });

    console.log(data);

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
            <Rooms />
            <Button size={'sm'} onClick={() => console.log('hi, how are you')}>
                Search
            </Button>
        </div>
    );
}
