Here are the things that remain todo. If solved, move to the solved section.

## TODO

* Parameters
  * pgnFile: Currently not possible, may be useful later.
  * pgn: Is the part of the section in between `[pgnv]` and `[/pgnv]`.
* Bugs / Problems

## Recommendations of the AI

Great to hear that it's working better now! Here are a few additional suggestions for your testing and the new version:

1. Thorough Testing:
   - Test with a variety of PGN formats, including games with comments, variations, and special characters.
   - Try PGNs of different lengths, from very short to very long.
   - Test with different shortcode attributes to ensure they're all working correctly.

2. Error Handling:
   - Consider adding more robust error handling. For example, if the PGN parsing fails, provide a meaningful error message to the user or admin.

3. Performance:
   - For long PGNs, you might want to consider lazy loading or pagination to improve performance.

4. Accessibility:
   - Ensure that the rendered chess board and moves are accessible, including keyboard navigation if possible.

5. Internationalization:
   - If you haven't already, make sure all user-facing strings are internationalized for easy translation.

6. Documentation:
   - Update your plugin's documentation to reflect any changes in how PGNs should be formatted or used within the shortcode.

7. Backwards Compatibility:
   - If this is a major change, consider how it might affect existing users and whether you need to provide any migration path or backwards compatibility.

8. Security:
   - Double-check that all user inputs are properly sanitized and escaped, especially if you're making changes to how content is processed.

9. Caching:
   - If applicable, implement or update caching mechanisms to improve performance, especially for frequently viewed PGNs.

10. Version Control:
    - Make sure to update your version numbers appropriately in both the plugin file and any readme files.

Once you've thoroughly tested and are satisfied with the changes, don't forget to update your changelog and any relevant documentation. If you're distributing this through the WordPress plugin repository, you'll want to submit the new version for review.

Good luck with the new version, and feel free to ask if you have any more questions during your testing and release process!
