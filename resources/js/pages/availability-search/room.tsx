import type { RoomAction, RoomData } from '@/types';
import { Minus, Plus, X } from 'lucide-react';

interface RoomComponentProps {
    room: RoomData;
    dispatchRooms: React.Dispatch<RoomAction>;
}

export default function Room({ room, dispatchRooms }: RoomComponentProps) {
    return (
        <div className="border">
            <div className="flex h-auto justify-end" onClick={() => dispatchRooms({ type: 'remove_room', payload: { uuid: room.uuid } })}>
                <span className={'cursor-pointer ' + `${!room.removable && 'invisible'}`}>
                    <X />
                </span>
            </div>
            <div className="grid grid-cols-[auto_auto_auto] gap-2">
                <span>Adults: {room.adults}</span>
                <span onClick={() => dispatchRooms({ type: 'add_adult', payload: { uuid: room.uuid } })}>
                    <Plus />
                </span>
                <span onClick={() => dispatchRooms({ type: 'remove_adult', payload: { uuid: room.uuid } })}>
                    <Minus />
                </span>
                <span>Children: {room.children}</span>
                <span onClick={() => dispatchRooms({ type: 'add_child', payload: { uuid: room.uuid } })}>
                    <Plus />
                </span>
                <span onClick={() => dispatchRooms({ type: 'remove_child', payload: { uuid: room.uuid } })}>
                    <Minus />
                </span>
            </div>
        </div>
    );
}
