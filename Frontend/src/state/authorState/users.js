import { defineStore } from 'pinia'
import axios from 'axios'

// Axios instance for cleaner API calls
const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/users'
})

export const useAuthorStore = defineStore('userStore', {
  state: () => ({
    users: [],        // List of all authors
    user: null,       // Single author detail
    loading: false,   // Global loading state
    error: null       // Error message from API
  }),

  getters: {
    hasError: (state) => !!state.error,
    isLoaded: (state) => !state.loading && state.users.length > 0
  },

  actions: {
    /**
     * Fetch all authors from the API.
     */
    async fetchAuthors() {
      this.loading = true
      this.error = null

      try {
        const response = await api.get('/')
        this.users = response.data
      } catch (error) {
        this.handleError(error)
      } finally {
        this.loading = false
      }
    },

    /**
     * Fetch a single author by ID.
     * @param {number} id - Author ID
     */
    async fetchAuthorById(id) {
      this.loading = true
      this.error = null
      this.user = null

      try {
        const response = await api.get(`/${id}`)
        this.user = response.data
      } catch (error) {
        this.handleError(error)
      } finally {
        this.loading = false
      }
    },

    /**
     * Create a new author.
     * @param {Object} authorData - New author data
     */
    async createAuthor(authorData) {
      this.error = null

      try {
        await api.post('/', authorData)
        await this.fetchAuthors()
      } catch (error) {
        this.handleError(error)
      }
    },

    /**
     * Update an existing author.
     * @param {number} id - Author ID
     * @param {Object} authorData - Updated author data
     */
    async updateAuthor(id, authorData) {
      this.error = null

      try {
        await api.put(`/${id}`, authorData)
        await this.fetchAuthors()
      } catch (error) {
        this.handleError(error)
      }
    },

    /**
     * Delete an author by ID.
     * @param {number} id - Author ID
     */
    async deleteAuthor(id) {
      this.error = null

      try {
        await api.delete(`/${id}`)
        await this.fetchAuthors()
      } catch (error) {
        this.handleError(error)
      }
    },

    /**
     * Reset the store to its initial state.
     */
    resetStore() {
      this.users = []
      this.user = null
      this.loading = false
      this.error = null
    },

    /**
     * Handle and normalize API errors.
     * @param {Object} error - Error object
     */
    handleError(error) {
      this.error =
        error?.response?.data?.message ||
        error.message ||
        'An unexpected error occurred'
      console.error('[AuthorStore Error]:', this.error)
    }
  }
})
