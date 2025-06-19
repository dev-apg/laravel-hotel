import ExtrasListComponent from '@/components/extras/extras-list-component';
import HotelDetails from '@/components/hotel-details';
import { Button } from '@/components/ui/button';
import type { BookingDetails } from '@/types';
import { useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

interface Props {
    bookingDetails: BookingDetails;
}

interface extrasFormData {
    bookingDetails: BookingDetails;
    [key: string]: any;
}

export default function extras({ bookingDetails }: Props) {
    console.log(bookingDetails);

    const { data, setData, post, processing, errors, reset } = useForm<extrasFormData>({
        bookingDetails: bookingDetails,
    });

    function submit(e: FormEvent) {
        e.preventDefault();
        return;
        post(route('bookings.create', {}), {});
    }
    const { hotel, from, to, rooms } = bookingDetails;
    return (
        <div>
            <div className="flex flex-col">
                <div className="p-2">
                    <HotelDetails hotel={hotel} />
                </div>

                <form onSubmit={submit} action="" method="post">
                    {rooms.map((room, index) => {
                        return (
                            <div className={'mb-4 rounded-lg border border-black bg-gray-50 p-4'} key={room.id}>
                                <p className="font-medium text-gray-900">Room {index + 1}</p>
                                <p>Adults: {room.adults}</p>
                                <p>{room.children > 0 && `Children: ${room.children}`}</p>
                                <ExtrasListComponent extras={room.extras} />
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
