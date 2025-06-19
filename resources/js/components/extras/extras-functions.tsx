export type ExtrasAction = {
    type: 'select_extra' | 'deselect_extra';
    payload: {
        roomId: number;
        extraId: number;
    };
};

export type ExtrasState = {
    selectedExtras: Map<number, Set<number>>; // roomId -> Set of extraIds
};

export const initialExtrasState: ExtrasState = {
    selectedExtras: new Map(),
};

export function extrasReducer(state: ExtrasState, action: ExtrasAction): ExtrasState {
    const { roomId, extraId } = action.payload;

    switch (action.type) {
        case 'select_extra': {
            const newSelectedExtras = new Map(state.selectedExtras);
            const currentExtras = newSelectedExtras.get(roomId) ?? new Set();
            currentExtras.add(extraId);
            newSelectedExtras.set(roomId, currentExtras);
            return { selectedExtras: newSelectedExtras };
        }
        case 'deselect_extra': {
            const newSelectedExtras = new Map(state.selectedExtras);
            const currentExtras = newSelectedExtras.get(roomId);
            if (currentExtras) {
                currentExtras.delete(extraId);
                if (currentExtras.size === 0) {
                    newSelectedExtras.delete(roomId);
                } else {
                    newSelectedExtras.set(roomId, currentExtras);
                }
            }
            return { selectedExtras: newSelectedExtras };
        }
        default:
            return state;
    }
}

export function isSelectedExtra(state: ExtrasState, roomId: number, extraId: number): boolean {
    const extrasForRoom = state.selectedExtras.get(roomId);
    return extrasForRoom ? extrasForRoom.has(extraId) : false;
}

export function getSelectedExtras(state: ExtrasState, roomId: number): number[] {
    const extrasForRoom = state.selectedExtras.get(roomId);
    return extrasForRoom ? Array.from(extrasForRoom) : [];
}

export function getSelectedExtrasForAllRooms(state: ExtrasState): Map<number, number[]> {
    const result = new Map<number, number[]>();
    state.selectedExtras.forEach((extras, roomId) => {
        result.set(roomId, Array.from(extras));
    });
    return result;
}
