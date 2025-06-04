import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { BookingFormData, BookingSetData, Hotel } from '@/types';

interface SelectHotelProps {
    hotels: Hotel[];
    data: BookingFormData;
    setData: BookingSetData;
}

export default function SelectHotel({ hotels, data, setData }: SelectHotelProps) {
    return (
        <Select value={data.hotel?.toString()} onValueChange={(value) => setData('hotel', value)}>
            <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Hotel" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    {hotels.map((hotel) => {
                        return (
                            <SelectItem key={hotel.id.toString()} value={hotel.id.toString()}>
                                {hotel.name}
                            </SelectItem>
                        );
                    })}
                </SelectGroup>
            </SelectContent>
        </Select>
    );
}
