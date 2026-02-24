function cartesian(...sets) {
    let result = [];

    for (const set of sets) {
        const temp = [];
        for (const value of set) {
            for (const combination of result) {
                temp.push([...combination, value]);
            }
        }
        result = temp;
    }

    return result;
}


console.log(cartesian([1,2,3],[4,5,6],[7,8,9]))