import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { BookingFormData, BookingSetData, Hotel } from '@/types';

interface SelectHotelProps {
    hotels: Hotel[];
    data: BookingFormData;
    setData: BookingSetData;
}

export default function SelectHotel({ hotels, data, setData }: SelectHotelProps) {
    return (
        <Select value={data.hotel_id?.toString()} onValueChange={(value) => setData('hotel_id', value)}>
            <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Choose your hotel" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Hotels</SelectLabel>
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
