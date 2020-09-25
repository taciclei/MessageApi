
An API returns you a response.
It might return you a Json Response, or an XML response.
The type of the response is defined by the request to the API. It means, that, in your request, you have a type=json or type=xml.
You have to manage the response through a set of Classes with a logic architecture.


In our case, the api request is set for receiving a json object. (See the content below).

You have to manage the return, thinking that, here you have Json, but in other case you might have XML.

Your code must be well constructed, in order to manage correctly the response. Think design-pattern.

You have to implement the Json Part, and only give the skeleton for the XML part.

When your response is managed, you have to deal with its content, and answer the following questions :

From your Json Object, you have to manage the following methods :

- Making a count of each message sent by the two users
- Displaying all messages
- Displaying one message

Remember that you are using Php 7.

Here is the object :



//GET domain.com/api/conversation/1200/json

$messages =
    '{
  "messages": {
    "12": {
      "message": "Hello, I want to rent your boat",
      "tenantId": "1505"
    },
    "14": {
      "message": "Did you receive my message?",
      "tenantId": "1505"
    },
    "23": {
      "message": "Yes. Sorry. For which dates?",
      "ownerId": "2546"
    },
    "35": {
      "message": "The 15 of April 2018 to the 20 of April 2018.",
      "tenantId": "1505"
    },
    "48": {
      "message": "Ok, no problem, let me send you a custom offer!",
      "ownerId": "2546"
    }
  }
}';

