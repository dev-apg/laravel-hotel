import { Hotel } from '@/types';
import SelectHotel from './select-hotel';

interface BookingRibbonProps {
    data: Data;
}

interface Data {
    hotels: Hotel[];
}

export default function BookingRibbon({ data }: BookingRibbonProps) {
    return (
        <div id="booking-ribbon">
            <SelectHotel hotels={data.hotels}></SelectHotel>
        </div>
    );
}
