
## Overview of the Vulnerability

Provide a 1-2 sentence description of the vulnerability.

This format is a good guide:
[VULNTYPE] in [COMPONENT] in [APPLICATION] allows [ATTACKER] to [IMPACT] via [VECTOR] 

## Business Impact

Provide an example of the impact to the business. This could be reputational damage, financial loss, a loss in customer trust, etc.

## Steps to Reproduce

Provide a step-by-step walkthrough on how to access the vulnerable injection point, and how to exploit the vulnerability.

Example:

1. Login to in-scope asset at <www.bugcrowd.com/login>
1. Browse to account page
1. Modify ID token to add single quote
1. View error which states 'SQL Syntax Error'
1. Replace ID value with `1' waitfor delay '00:00:10'; `


## Proof of Concept (PoC)

Your submission must include evidence of the vulnerability and not be theoretical in nature.
You may present your evidence as output from a tool, such as SQLMap, unless the program forbids the use of these tools. Evidence may also be in the format of terminal output, screenshots, or video.
Use this section to demonstrate clearly the effect of the vulnerability. However, do not access Personally Identifiable Information (PII).
