import AncillariesListComponent from '@/components/ancillaries/ancillaries-list-component';
import UpgradeRoom from '@/components/ancillaries/upgrade-room';
import HotelDetails from '@/components/hotel-details';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

interface AncillariesProps {
    ancillariesData: any;
}

interface AncillariesFormData {
    hotel: string;
    from: string;
    to: string;
    rooms: string;
}

export default function Ancillaries({ ancillariesData }: AncillariesProps) {
    console.log(ancillariesData);
    const { hotel, from, to, rooms, rooms_data, ancillaries } = ancillariesData;

    const { data, setData, get, processing, errors, reset } = useForm<Required<AncillariesFormData>>({
        hotel: hotel,
        from: from,
        to: to,
        rooms: rooms,
    });

    function submit(e: FormEvent) {
        e.preventDefault();
        return;
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
                            <div className={'mb-4 rounded-lg border border-black bg-gray-50 p-4'} key={room_data.id}>
                                <p className="font-medium text-gray-900">Room {index + 1}</p>
                                <p>Adults: {room_data.adults}</p>
                                <p>{room_data.children > 0 && `Children: ${room_data.children}`}</p>
                                {room_data.upgradeable && <UpgradeRoom room_data={room_data} />}
                                <AncillariesListComponent ancillaries={room_data.available_ancillaries} />
                            </div>
                        );
                    })}
                    <div className="flex justify-end">
                        <Button>Continue</Button>
                    </div>
                </form>
            </div>
        </div>
    );
}
