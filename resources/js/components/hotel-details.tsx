import { Hotel } from '@/types';

interface HotelDetailsProps {
    hotel: Hotel;
}

export default function HotelDetails({ hotel }: HotelDetailsProps) {
    const { name, address_line_1, address_line_2, county, postcode } = hotel;
    return (
        <div>
            <p className="font-bold">{name}</p>
            <p>{address_line_1}</p>
            <p>{address_line_2}</p>
            <p>{county}</p>
            <p>{postcode}</p>
        </div>
    );
}
