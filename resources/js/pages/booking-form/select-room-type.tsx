import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { RoomAction, RoomData } from '@/types';
import { RoomType } from './enums';

interface SelectRoomTypeProps {
    room: RoomData;
    dispatchRooms: React.Dispatch<RoomAction>;
}

export default function SelectRoomType({ room, dispatchRooms }: SelectRoomTypeProps) {
    return (
        <Select
            value={room.type}
            onValueChange={(value: RoomType) => dispatchRooms({ type: 'update_room_type', payload: { uuid: room.uuid, type: value } })}
        >
            <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Choose your hotel" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Hotels</SelectLabel>
                    {room.typeList.map((type) => {
                        return (
                            <SelectItem key={type} value={type}>
                                {type}
                            </SelectItem>
                        );
                    })}
                </SelectGroup>
            </SelectContent>
        </Select>
    );
}
