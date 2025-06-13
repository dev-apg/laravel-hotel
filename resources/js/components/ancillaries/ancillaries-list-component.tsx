import { type Ancillary } from '@/types';
import AncillaryComponent from './ancillary-component';

interface AncillariesListComponentProps {
    ancillaries: Ancillary[];
}

export default function AncillariesListComponent({ ancillaries }: AncillariesListComponentProps) {
    return (
        <div>
            {ancillaries.map((ancillary) => (
                <AncillaryComponent key={ancillary.id} ancillary={ancillary} />
            ))}
        </div>
    );
}
