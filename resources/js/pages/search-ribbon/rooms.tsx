import { Button } from '@/components/ui/button';
import { Popover, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import type { RoomData } from '@/types';
import { PopoverContent } from '@radix-ui/react-popover';
import { useReducer } from 'react';
import Room from './room';

interface Action {
    type: string;
    payload: Payload;
}

interface Payload {
    uuid: string;
}

function newRoomData(removable = true): RoomData {
    return { uuid: self.crypto.randomUUID(), removable: false, adults: 1, children: 0 };
}

export default function Rooms() {
    const [rooms, dispatchRooms] = useReducer(reducer, [newRoomData(false)]);

    function reducer(rooms: RoomData[], action: Action) {
        if (action.type == 'add_room') {
            return [...rooms, { uuid: self.crypto.randomUUID(), removable: true, adults: 1, children: 0 }];
        }

        let cloned = structuredClone(rooms);

        const target = cloned.find((room) => room.uuid == action.payload.uuid);

        if (!target) {
            return cloned;
        }

        switch (action.type) {
            case 'remove_room':
                if (target.removable) {
                    cloned = cloned.filter((room) => room.uuid != target.uuid);
                }
                break;
            case 'add_adult':
                if (target.adults == 1) {
                    target.adults = target.adults + 1;
                }
                break;
            case 'remove_adult':
                if (target.adults == 2) {
                    target.adults = target.adults - 1;
                }
                break;
            case 'add_child':
                if (target.children <= 2) {
                    target.children = target.children + 1;
                }
                break;
            case 'remove_child':
                if (target.children > 0) {
                    target.children = target.children - 1;
                }
                break;
            default:
                throw new Error('action type note found');
                break;
        }

        return cloned;
    }

    console.log(
        rooms.reduce((acc, room) => {
            let result = acc + room.adults.toString() + ',';
            console.log(rooms.findIndex((room) => room));

            return result;
        }, ''),
    );

    const roomsTotal = rooms.length;
    const adultsTotal = rooms.reduce((acc, el) => {
        return acc + el.adults;
    }, 0);
    const childrenTotal = rooms.reduce((acc, el) => {
        return acc + el.children;
    }, 0);

    return (
        <Popover>
            <PopoverTrigger asChild>
                <Button id="date" variant={'outline'} className={cn('justify-start text-left font-normal')}>
                    Rooms: {roomsTotal} Adults: {adultsTotal} {childrenTotal > 0 && `ChildrenTotal: ${childrenTotal}`}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="w-auto p-0" align="start">
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                    {rooms.map((room) => (
                        <Room key={room.uuid} room={room} dispatchRooms={dispatchRooms} />
                    ))}
                    {rooms.length < 6 && <Button onClick={() => dispatchRooms({ type: 'add_room', payload: newRoomData() })}>Add Room</Button>}
                </div>
            </PopoverContent>
        </Popover>
    );
}
