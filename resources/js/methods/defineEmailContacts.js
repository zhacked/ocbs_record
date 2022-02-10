const defineEmail = (arrayEmail) => {
         
    if (arrayEmail != null) {
        const emailMap = arrayEmail.map((ed) => ed["email"]);

        const ee = emailMap.reduce((prev, current) => {
            return current + " " + prev;
        }, "");
        // return ee.trim().replace(/\s/g, " / ");
        return ee.trim();
        // return arrayEmail[0].email;
    }
}

const defineContact = (arrayContact) => {
        
    if (arrayContact != null) {
        const emailMap = arrayContact.map((ed) => ed["contact_number"]);

        const ee = emailMap.reduce((prev, current) => {
            return current + " " + prev;
        }, "");
        // return ee.trim().replace(/\s/g, " / ");
        return ee.trim();
    }
}

export {
    defineEmail,
    defineContact
}