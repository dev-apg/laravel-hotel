import { type Ancillary } from '@/types';

interface AncillaryProps {
    ancillary: Ancillary;
}

export default function AncillaryComponent({ ancillary }: AncillaryProps) {
    const { name, description } = ancillary;
    return (
        <div className="p-2">
            <p className="font-bold">{name}</p>
            <p>{description}</p>
        </div>
    );
}
