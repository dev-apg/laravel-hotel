import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Hotel } from '@/types';
interface SelectHotelProps {
    hotels: Hotel[];
}

export default function SelectHotel({ hotels }: SelectHotelProps) {
    return (
        <Select>
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
