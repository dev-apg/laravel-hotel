import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { type Ancillary } from '@/types';

interface AncillaryProps {
    ancillary: Ancillary;
}

export default function UpgradeRoom({ room_data }) {
    const { id } = room_data;
    return (
        <div className="p-2">
            <div className="flex items-center gap-2">
                <Label className="text-xl" htmlFor={id.toString()}>
                    Upgrade room?
                </Label>
                <Checkbox id={id.toString()} className="" />
            </div>
            <p>You can upgrade your room if you want</p>
        </div>
    );
}
