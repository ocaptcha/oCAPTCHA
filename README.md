# oCAPTCHA

A free and open-source CAPTCHA-solution, written in `php` and `python`. oCAPTCHA is an acronym for: _open Completely Automatic Public (turing) Test (to tell) Computers (and) Humans Apart_.

## What does it look like?

An oCAPTCHA consists of a background-image, multiple fonts and an overlay:

**Solution: `T09JLD`**
![Solution: T09JLD](https://i.ibb.co/zNp2tLk/72d3b7d7e10920f31b590d31e99e596202567f8d32bc3a6c7c53c4f70861291a-T09-JLD.png)
**Solution: `WIOM3O`**
![Solution: WIOM3O](https://i.ibb.co/54WJYvj/37138a1efd75e88dca72283111096b236e6599e752e47904e6d1be16be168301-WIOM3-O.png)
**Solution: `24ACDR`**
![24ACDR](https://i.ibb.co/nsPmjjh/b766d51885c21d200b81fa9f5bcfc2a62d63a0b1888885e83d2a7cb47b87afdf-24-ACDR.png)
## How does it work?

### Creating an oCAPTCHA:

Visit `api.ocaptcha.com/create` to retrieve the identifier for your newly created oCAPTCHA. If everything worked without any errors, the response-body will look like this:

```
{
	code: 200,
	error: false,
	id: "[oCAPTCHA-identifier]"
}
```

### Getting the oCAPTCHA:

You access the oCAPTCHA at `api.ocaptcha.com/?id=[oCAPTCHA-identifier]`. Embedding an oCAPTCHA in basic HTML can look something like this:

```
<img class="oCAPTCHA" scr="api.ocaptcha.com/?id=[oCAPTCHA-identifier]" alt="oCAPTCHA challenge">
```

### Verifying the oCAPTCHA:

After you have retrieved the users solution, you can check wether it is correct or not, by visiting `api.ocaptcha.com/verify/?id=[oCAPTCHA-identifier]&solution=[user-solution]`. If everything worked without any errors, the response-body will look like this:

```
{
	code: 200,
	error: false,
	score: "[float between 0 and 100]"
}
```

As you can see, oCAPTCHA does not tell you if the user-solution is correct. Instead, it returns a score that is based on how many characters of the users-solution match the actual solution. It is up to you, how high the score has to be, before the can user continue. I suggest, that a valid score has to be above `80`.

## Errors

If something went wrong while completing the above steps, the server will give you an error that looks like this:

```
{
	code: [HTTP-response-status],
	error: "[Error-message]"
}
```

If you have problems resolving an error, feel free to open a GitHub issue.