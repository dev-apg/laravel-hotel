import { Button } from '@/components/ui/button';
import { Popover, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { RoomAction, RoomData } from '@/types';
import { PopoverContent } from '@radix-ui/react-popover';
import Room from './room';

interface RoomsProps {
    rooms: RoomData[];
    dispatchRooms: React.Dispatch<RoomAction>;
}

export default function Rooms({ rooms, dispatchRooms }: RoomsProps) {
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
                    {rooms.length < 6 && (
                        <Button
                            type="button"
                            onClick={(e) => {
                                dispatchRooms({ type: 'add_room' });
                            }}
                        >
                            Add Room
                        </Button>
                    )}
                </div>
            </PopoverContent>
        </Popover>
    );
}
