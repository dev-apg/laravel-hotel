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
                <HotelDetails hotel={hotel} />
                <AncillariesListComponent ancillaries={ancillaries} />
                {/* <span>checkin: {checkin}</span>
                <span>checkout: {checkout}</span>
                <span>adults: {adults}</span>
                <span>children: {children}</span> */}
            </div>
        </div>
    );
}
