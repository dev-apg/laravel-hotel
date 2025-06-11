import AncillariesListComponent from '@/components/ancillaries/ancillaries-list-component';
import HotelDetails from '@/components/hotel-details';
import { useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

interface AncillariesProps {
    props: any;
}

interface AncillariesFormData {
    hotel: string;
    from: string;
    to: string;
    rooms: string;
    adults: string;
    children: string;
}

export default function Ancillaries({ props }: AncillariesProps) {
    console.log(props);
    const { hotel, from, to, rooms, adults, children, rooms_data, ancillaries } = props;

    const { data, setData, get, processing, errors, reset } = useForm<Required<AncillariesFormData>>({
        hotel: hotel,
        from: from,
        to: to,
        rooms: rooms,
        adults: adults,
        children: children,
    });

    function submit(e: FormEvent) {
        e.preventDefault();
        get(route('bookings.create', {}), {});
    }

    return (
        <div>
            <div className="flex flex-col">
                <div className="p-2">
                    <HotelDetails hotel={hotel} />
                </div>

                <form onSubmit={submit} action="" method="get">
                    {rooms_data.map((room_data, index) => {
                        return (
                            <div key={room_data.id}>
                                <p>Room number: {index + 1}</p>
                                <AncillariesListComponent ancillaries={room_data.available_ancillaries} />
                            </div>
                        );
                    })}
                </form>
            </div>
        </div>
    );
}
