class Server {
    static url = `${document.location.origin}/Ajax/main.php`;
    

    /**
     * 
     * @param {Function} callback 
     */
    static async get(callback) {
        const response = await fetch(this.url)
            callback(await response.json())
    }
    /**
     * @method Sends a post request to {chicjoint.php}, returns a promise which is handled by callback function
     * @param {JSON} data data to be sent to the server.
     * @param {Function} callback This is called if the we get a positive response
     * @returns promise
     */
    static async post(data, callback) {
        const response = await fetch(this.url, {
            method: 'post',
            body: JSON.stringify(data)
        })
        callback(await response.json());
    }

}
