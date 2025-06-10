import AncillariesListComponent from '@/components/ancillaries/ancillaries-list-component';
import HotelDetails from '@/components/hotel-details';

interface AncillariesProps {
    props: any;
}

export default function Ancillaries({ props }: AncillariesProps) {
    console.log(props);
    const { hotel, checkin, checkout, adults, children, ancillaries } = props;

    return (
        <div>
            <div className="flex flex-col">
                <div className="p-2">
                    <HotelDetails hotel={hotel} />
                </div>
                <AncillariesListComponent ancillaries={ancillaries} />
            </div>
        </div>
    );
}
