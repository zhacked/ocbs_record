import numbro from 'numbro';


const numberFormat = (number = 0, decimal = 2) => {
    return numbro(number).format({
        thousandSeparated: true,
        negative: "parenthesis",
        mantissa: decimal
    })
}

const numberUnformat = (string) => {
    return numbro.unformat(string)
}

const toFixed = (number, decimal = 3) => {
	return number.toFixed(decimal);
};

const formatter = (number) => {
	return new Intl.NumberFormat('en-PH', {
		minimumFractionDigits: 2, 
		maximumFractionDigits: 2, 
	  }).format(number);
 }

const moneyFormat = (num, decimal = 2) => {
    // const money = parseFloat(num) < -1 ? parseFloat(num) : toFixed(parseFloat(num))
    const money = toFixed(parseFloat(num))
    // const money = parseFloat(num)
    return numberFormat(formatter(money), decimal)

};


export { numberFormat, numberUnformat, moneyFormat }