import { type Ancillary } from '@/types';
import AncillaryComponent from './ancillary-component';

interface extrasListComponentProps {
    extras: Ancillary[];
}

export default function extrasListComponent({ extras }: extrasListComponentProps) {
    return (
        <div>
            {extras.map((ancillary) => (
                <AncillaryComponent key={ancillary.id} ancillary={ancillary} />
            ))}
        </div>
    );
}
