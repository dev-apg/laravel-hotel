interface AncillariesProps {
    props: any;
}

export default function Ancillaries({ props }: AncillariesProps) {
    console.log(props);
    const { hotel, checkin, checkout, adults, children } = props;

    return (
        <div>
            <div className="flex flex-col">
                <span>hotel: {hotel}</span>
                <span>checkin: {checkin}</span>
                <span>checkout: {checkout}</span>
                <span>adults: {adults}</span>
                <span>children: {children}</span>
            </div>
        </div>
    );
}
